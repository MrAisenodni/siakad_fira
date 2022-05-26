<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('mst_lesson');
            $table->foreignId('teacher_id')->constrained('mst_teacher');
            $table->foreignId('student_id')->constrained('mst_student');
            $table->foreignId('class_id')->constrained('mst_class');
            $table->foreignId('study_year_id')->constrained('mst_study_year');
                                    
            // Struktur Baku
            $table->boolean('disabled')->default(0);
            $table->string('created_by')->nullable();
            $table->dateTime('created_at')->default(now());
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('std_lesson');
    }
}
