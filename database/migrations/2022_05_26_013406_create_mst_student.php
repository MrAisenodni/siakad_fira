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
            $table->string('nis', 10)->unique();
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_data');
            $table->enum('gender', ['l', 'p']);
            $table->unsignedInteger('religion_id')->nullable();
            $table->unsignedInteger('family_status_id')->nullable();
            $table->string('child_to', 3);
            $table->text('address');
            $table->string('phone_number', 25)->nullable();
            $table->string('first_study')->nullable();
            $table->string('major')->nullable();
            $table->date('study_date')->nullable();
            $table->text('picture')->nullable();
            $table->unsignedInteger('study_year')->nullable();

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
