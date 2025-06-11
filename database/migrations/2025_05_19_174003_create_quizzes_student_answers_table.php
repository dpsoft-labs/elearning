<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes_student_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_attempt_id')->unsigned();
            $table->foreign('quiz_attempt_id')->references('id')->on('quizzes_attempts')->onDelete('cascade');
            $table->unsignedBigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('quizzes_questions')->onDelete('cascade');
            $table->unsignedBigInteger('answer_id')->nullable()->unsigned();
            $table->foreign('answer_id')->references('id')->on('quizzes_answers')->onDelete('cascade');
            $table->text('essay_answer')->nullable(); // للأسئلة المقالية
            $table->boolean('is_correct');
            $table->integer('points_earned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes_student_answers');
    }
}

