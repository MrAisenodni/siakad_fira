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
            $table->year('year');
            $table->unsignedInteger('month_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->string('present')->nullable();
            $table->integer('absent')->nullable();
            $table->integer('sick')->nullable();
            $table->integer('permit')->nullable();
                                    
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
