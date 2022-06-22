<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdPresent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_present', function (Blueprint $table) {
            $table->id();
            $table->date('study_date')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->integer('present')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('sick')->default(0);
            $table->integer('permit')->default(0);
                                    
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
        Schema::dropIfExists('std_present');
    }
}
