<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration')->comment('بالدقائق');
            $table->integer('passing_score');
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_time')->nullable(); // وقت بداية الاختبار
            $table->timestamp('end_time')->nullable(); // وقت نهاية الاختبار
            $table->unsignedBigInteger('course_id');
            $table->boolean('is_random_questions')->default(true);
            $table->boolean('is_random_answers')->default(true);
            $table->enum('show_result', ['after_exam_end', 'after_submission', 'manual'])->default('after_submission')->comment('توقيت إظهار النتيجة: بعد انتهاء وقت الامتحان، بعد التسليم مباشرة، يدوياً من الادمن');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::dropIfExists('quizzes');
    }
}

