<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_teacher', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('full_name');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['l' ,'p']);
            $table->string('phone_number', 25)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('last_study')->nullable();
            $table->unsignedInteger('religion_id')->nullable(); // Foreign Key ke tabel mst_religion
            $table->enum('role', ['teacher', 'head'])->nullable();
            $table->text('address')->nullable();
            $table->text('picture')->nullable();
            $table->string('field_study')->nullable();
            $table->string('role_admin')->nullable();
            $table->boolean('curriculum_assist')->default(0); // Wakil Kurikulum
            $table->boolean('student_assist')->default(0); // Wakil Kesiswaan
            $table->boolean('facilities_assist')->default(0); // Wakil Sarana dan Prasarana
            $table->boolean('emissary_assist')->default(0); // Wakil Caraka
            
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
        Schema::dropIfExists('mst_teacher');
    }
}
