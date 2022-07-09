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
            $table->unsignedInteger('student_id')->nullable(); // Foreign Key ke tabel mst_student
            $table->unsignedInteger('lesson_id')->nullable(); // Foreign Key ke tabel std_lesson
            $table->unsignedInteger('class_id')->nullable(); // Foreign Key ke tabel std_class
            $table->decimal('ph1')->nullable();
            $table->decimal('ph2')->nullable();
            $table->decimal('ph3')->nullable();
            $table->decimal('ph4')->nullable();
            $table->decimal('ph5')->nullable();
            $table->decimal('r1')->nullable();
            $table->decimal('r2')->nullable();
            $table->decimal('r3')->nullable();
            $table->decimal('r4')->nullable();
            $table->decimal('r5')->nullable();
            $table->decimal('n1')->nullable();
            $table->decimal('n2')->nullable();
            $table->decimal('n3')->nullable();
            $table->decimal('n4')->nullable();
            $table->decimal('n5')->nullable();
            $table->decimal('avg_ph')->nullable();
            $table->decimal('t1')->nullable();
            $table->decimal('t2')->nullable();
            $table->decimal('t3')->nullable();
            $table->decimal('t4')->nullable();
            $table->decimal('t5')->nullable();
            $table->decimal('avg_t')->nullable();
            $table->decimal('k1')->nullable();
            $table->decimal('k2')->nullable();
            $table->decimal('k3')->nullable();
            $table->decimal('k4')->nullable();
            $table->decimal('k5')->nullable();
            $table->decimal('avg_k')->nullable();
            $table->decimal('pts')->nullable();
            $table->decimal('pas')->nullable();
            $table->decimal('npa')->nullable();
            $table->char('score')->nullable();
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