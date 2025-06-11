<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'quizzes_answers';

    protected $fillable = [
        'answer_text',
        'answer_image',
        'is_correct',
        'question_id'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(QuizStudentAnswer::class, 'answer_id');
    }
}