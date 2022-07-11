<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdReportCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_report_card', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('study_year_id')->nullable();
            $table->unsignedInteger('score_id')->nullable();
            $table->unsignedInteger('present_id')->nullable();
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
        Schema::dropIfExists('std_report_card');
    }
}
