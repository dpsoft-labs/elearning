<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'passing_score',
        'is_active',
        'start_time',
        'end_time',
        'course_id',
        'is_random_questions',
        'is_random_answers',
        'show_result'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
        'is_random_questions' => 'boolean',
        'is_random_answers' => 'boolean'
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getStartTimeForInputAttribute()
    {
        return $this->start_time ? $this->start_time->format('Y-m-d\TH:i') : '';
    }

    public function getEndTimeForInputAttribute()
    {
        return $this->end_time ? $this->end_time->format('Y-m-d\TH:i') : '';
    }

    public function totalGrade()
    {
        return $this->questions()->sum('points');
    }

    public function notAttemptedStudents()
    {
        return $this->course->students()
            ->whereDoesntHave('attempts', function ($query) {
                $query->where('quiz_id', $this->id);
            })
            ->orWhereHas('attempts', function ($query) {
                $query->where('quiz_id', $this->id)
                      ->whereNull('completed_at');
            });
    }
}