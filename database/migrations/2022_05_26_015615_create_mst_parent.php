<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_parent', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->nullable();

            // Personal
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('gender', ['l', 'p'])->nullable();
            $table->enum('citizen', ['wni', 'wna'])->nullable();
            $table->unsignedInteger('religion_id')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('home_number', 25)->nullable();
            $table->boolean('parent')->default(1);
            
            // Other
            $table->string('last_study')->nullable();
            $table->unsignedInteger('occupation_id')->nullable();
            $table->double('revenue')->nullable();
            $table->enum('revenue_type', ['day', 'month', 'year']);
            $table->boolean('died')->default(0);

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
        Schema::dropIfExists('mst_parent');
    }
}
