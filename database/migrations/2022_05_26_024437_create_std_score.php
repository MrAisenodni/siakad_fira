<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('lesson_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->decimal('avg_ph')->nullable();
            $table->decimal('avg_t')->nullable();
            $table->decimal('score_3')->nullable();
            $table->decimal('score_4')->nullable();
            $table->decimal('score_uts')->nullable();
            $table->decimal('score_uas')->nullable();
            $table->decimal('score_na')->nullable();
            $table->decimal('score_avg')->nullable();
            $table->text('description')->nullable();
                                    
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
        Schema::dropIfExists('std_score');
    }
}