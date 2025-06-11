<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }

    /**
     * العلاقة مع الدورات التي سجل فيها المستخدم
     */
    public function userCourses()
    {
        return $this->belongsToMany(Course::class, 'courses_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function isOnline()
    {
        return DB::table('sessions')
            ->where('user_id', $this->id) // معرف المستخدم الحالي
            ->where('last_activity', '>=', now()->subMinutes(5)->timestamp) // خلال آخر 5 دقائق
            ->exists();
    }

    public function lastActivity()
    {
        return DB::table('sessions')
            ->where('user_id', $this->id)
            ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
            ->first();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * العلاقة مع المحادثات التي يشارك فيها المستخدم
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_participants')
            ->withPivot(['is_admin', 'last_read_at'])
            ->withTimestamps();
    }

    /**
     * العلاقة مع المحادثات التي أنشأها المستخدم
     */
    public function createdChats()
    {
        return $this->hasMany(Chat::class, 'created_by');
    }

    /**
     * العلاقة مع رسائل المحادثة التي أرسلها المستخدم
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * الحصول على المحادثات غير المقروءة
     */
    public function unreadChats()
    {
        return $this->chats()
            ->whereHas('messages', function ($query) {
                $query->whereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at')
                    ->where('chat_messages.user_id', '!=', $this->id);
            })
            ->orWhereHas('messages', function ($query) {
                $query->whereNull('chat_participants.last_read_at')
                    ->where('chat_messages.user_id', '!=', $this->id);
            });
    }
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function courseQuizzes()
    {
        return $this->hasManyThrough(
            Quiz::class,
            Course::class,
            'id', // Foreign key on courses table
            'course_id', // Foreign key on quizzes table
            'college_id', // Local key on users table
            'id' // Local key on courses table
        );
    }

    public function getQuizAttemptDetails($quizId)
    {
        return $this->attempts()
            ->where('quiz_id', $quizId)
            ->latest()
            ->first();
    }

    public function canImpersonate()
    {
        if (!Gate::allows('show users')) {
            return false;
        }
        return true;
    }

    public function canBeImpersonated()
    {
        return true;
    }

    public function getPhotoAttribute()
    {
        //use auth()->user()->photo not auth()->user()->image

        if (isset($this->attributes['image']) && $this->attributes['image'] !== null && file_exists(public_path($this->attributes['image']))) {
            return asset($this->attributes['image']);
        } else {

            return asset('images/usersProfile/profile.png');

            // if (auth()->user()->gender == 'male') {
            //     return url('assets/img/team-3.jpg');
            // }
            // elseif (auth()->user()->gender == 'female') {
            //     return url('assets/img/team-1.jpg');
            // }
        }
    }

    public function getSidAttribute()
    {
        // استخراج آخر رقمين من السنة التي أنشئ فيها المستخدم
        $yearDigits = substr($this->created_at->format('Y'), -2);

        // تحويل الـ ID إلى سلسلة نصية
        $idString = (string)$this->id;

        // إذا كان الـ ID أقل من 5 أرقام، نضيف أصفار في البداية
        if (strlen($idString) < 5) {
            $idString = str_pad($idString, 5, '0', STR_PAD_LEFT);
        }

        // دمج رقمي السنة مع الـ ID
        return $yearDigits . $idString;
    }

    const PROTECTED_EMAILS = [
        'root@admin.com',
        'admin@admin.com'
    ];

    /**
     * الحصول على المواد التي اجتازها الطالب بنجاح
     */
    public function successCourses()
    {
        return $this->belongsToMany(Course::class, 'courses_user')
                    ->withPivot(['status', 'quizzes', 'midterm', 'attendance', 'final', 'total'])
                    ->wherePivot('status', 'success')
                    ->withTimestamps();
    }

    /**
     * الحصول على مجموع ساعات المواد التي اجتازها الطالب بنجاح
     */
    public function totalSuccessHours()
    {
        return $this->successCourses()->sum('hours');
    }

    /**
     * التحقق من اجتياز الطالب لمقرر معين (بالكود)
     */
    public function hasPassedCourse($courseCode)
    {
        return $this->successCourses()->where('code', $courseCode)->exists();
    }

    /**
     * الحصول على المقررات المتاحة للطالب بناءً على الشروط
     */
    public function availableCourses()
    {
        // الحصول على كلية الطالب
        $collegeId = $this->college_id;

        // الحصول على المقررات التي سجلها الطالب مسبقاً
        $registeredCourseIds = $this->userCourses()->pluck('courses.id')->toArray();

        // الحصول على المقررات التي اجتازها الطالب بالفعل
        $passedCourseCodes = $this->successCourses()->pluck('code')->toArray();

        // مجموع الساعات التي اجتازها الطالب
        $totalSuccessHours = $this->totalSuccessHours();

        // البحث عن المقررات المتاحة
        $availableCourses = Course::where('is_active', 1)
            ->where(function($query) use ($collegeId) {
                // شرط تطابق الكلية
                $query->where('college_id', $collegeId);
            })
            ->whereNotIn('id', $registeredCourseIds) // لم يسجل بها مسبقاً
            ->where(function($query) use ($passedCourseCodes, $totalSuccessHours) {
                $query->where(function($q) use ($passedCourseCodes) {
                    // لا توجد متطلبات سابقة أو تم اجتياز المتطلبات
                    $q->whereNull('required1')
                      ->orWhereIn('required1', $passedCourseCodes);
                })
                ->where(function($q) use ($passedCourseCodes) {
                    $q->whereNull('required2')
                      ->orWhereIn('required2', $passedCourseCodes);
                })
                ->where(function($q) use ($passedCourseCodes) {
                    $q->whereNull('required3')
                      ->orWhereIn('required3', $passedCourseCodes);
                })
                ->where(function($q) use ($totalSuccessHours) {
                    // التحقق من عدد الساعات المطلوبة
                    $q->where('required_hours', '<=', $totalSuccessHours)
                      ->orWhere('required_hours', 0);
                });
            })
            ->get();

        return $availableCourses;
    }
}
