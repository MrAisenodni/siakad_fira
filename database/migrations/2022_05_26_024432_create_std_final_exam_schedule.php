<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdFinalExamSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_final_exam_schedule', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->unsignedInteger('teacher_id')->nullable(); // Foreign Key ke tabel mst_teacher
            $table->unsignedInteger('lesson_id')->nullable(); // Foreign Key ke tabel std_lesson
            $table->unsignedInteger('class_id')->nullable(); // Foreign Key ke tabel mst_lesson untuk Ruangan Ujian
                                    
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
        Schema::dropIfExists('std_final_exam_schedule');
    }
}
