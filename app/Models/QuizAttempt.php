<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'quizzes_attempts';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'started_at',
        'completed_at',
        'is_passed'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_passed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(QuizStudentAnswer::class, 'quiz_attempt_id');
    }
}