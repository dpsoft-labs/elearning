<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'quizzes_questions';

    protected $fillable = [
        'question_text',
        'question_image',
        'type',
        'points',
        'quiz_id'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(QuizStudentAnswer::class, 'question_id');
    }
}