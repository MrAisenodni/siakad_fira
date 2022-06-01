<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdStudySchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_study_schedule', function (Blueprint $table) {
            $table->id();
            $table->enum('day', [1,2,3,4,5,6,7]);
            $table->time('clock');
            $table->enum('type', ['std', 'uts', 'uas']);
            $table->unsignedInteger('spv_teacher_id')->nullable();
            $table->foreignId('lesson_id')->constrained('std_lesson');
                                    
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
        Schema::dropIfExists('std_study_schedule');
    }
}
