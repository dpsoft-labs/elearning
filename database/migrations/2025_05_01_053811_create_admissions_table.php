<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('en_name');
            $table->string('ar_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('gender');
            $table->string('date_of_birth');
            $table->string('nationality');
            $table->string('national_id');
            // Education Information
            $table->string('certificate_type'); // ازهرى  او لغات أو عام
            $table->string('school_name'); // اسم المدرسة
            $table->string('graduation_year'); // سنة التخرج
            $table->decimal('grade_percentage', 5, 2); // النسبة المئوية
            $table->string('grade_evaluation'); // التقييم العام
            $table->string('academic_section'); // علوم أو رياضة
            // Parent information
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_job');
            // Images
            $table->string('student_photo');
            $table->string('certificate_photo');
            $table->string('national_id_photo');
            $table->string('parent_national_id_photo');

            $table->string('status'); // pending, accepted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
