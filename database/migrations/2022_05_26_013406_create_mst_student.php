<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_student', function (Blueprint $table) {
            $table->id();

            // Personal
            $table->string('nis', 25)->unique();
            $table->string('nik', 16)->unique();
            $table->string('nisn', 25)->unique();
            $table->string('full_name')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['l', 'p'])->nullable();
            $table->unsignedInteger('religion_id')->nullable();
            $table->unsignedInteger('language_id')->nullable();
            $table->unsignedInteger('blood_type_id')->nullable();
            $table->string('diagnose')->nullable();
            $table->string('physical_disorder')->nullable();
            $table->decimal('height', 5)->nullable();
            $table->decimal('weight', 5)->nullable();
            $table->text('picture')->nullable();

            // Family
            $table->unsignedInteger('family_status_id')->nullable();
            $table->string('child_to', 3);
            $table->string('child_count', 3)->nullable();
            $table->string('stepbrother_count', 3)->nullable();
            $table->string('stepsibling_count', 3)->nullable();
            $table->enum('citizen', ['wni', 'wna'])->nullable();
            
            // Contact
            $table->text('address')->nullable();
            $table->decimal('distance')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('home_number', 25)->nullable();

            // Study
            $table->string('level')->nullable();
            $table->string('group')->nullable();
            $table->date('start_date')->nullable();
            $table->unsignedInteger('extracurricular_id')->nullable();
            $table->unsignedInteger('study_year_id')->nullable();

            // Last Study
            $table->string('sttb_no')->unique()->nullable();
            $table->string('first_study')->nullable();
            $table->string('major')->nullable();
            $table->date('from_study_date')->nullable();
            $table->date('to_study_date')->nullable();

            // Other Study
            $table->string('move_from')->nullable();
            $table->string('move_reason')->nullable();

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
        Schema::dropIfExists('mst_student');
    }
}
