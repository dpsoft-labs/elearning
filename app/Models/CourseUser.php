<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    use HasFactory;

    /**
     * اسم الجدول المرتبط بهذا النموذج
     *
     * @var string
     */
    protected $table = 'courses_user';

    /**
     * الخصائص التي يمكن تعيينها بشكل جماعي
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'user_id',
        'status',
        'quizzes',
        'midterm',
        'attendance',
        'final',
        'total',
    ];

    /**
     * تحويل أعمدة معينة
     *
     * @var array
     */
    protected $casts = [
        'quizzes' => 'float',
        'midterm' => 'float',
        'attendance' => 'float',
        'final' => 'float',
        'total' => 'float',
    ];

    /**
     * العلاقة مع الدورة
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}