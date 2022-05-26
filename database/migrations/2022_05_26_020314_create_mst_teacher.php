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
            $table->string('nip')->unique();
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['l' ,'p']);
            $table->string('phone_number', 25)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('last_study')->nullable();
            $table->text('picture')->nullable();
            $table->unsignedInteger('religion_id')->nullable();
            $table->enum('role', ['teacher', 'head'])->nullable();
            
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
