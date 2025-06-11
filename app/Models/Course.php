<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * الخصائص التي يمكن تعيينها بشكل جماعي
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'hours',
        'image',
        'college_id',
        'required1',
        'required2',
        'required3',
        'required_hours',
        'is_active',
    ];

    /**
     * الخصائص التي يجب تحويلها
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع الكلية
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * العلاقة مع المستخدمين المسجلين في الدورة
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'courses_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'courses_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function lives()
    {
        return $this->hasMany(Live::class);
    }
}