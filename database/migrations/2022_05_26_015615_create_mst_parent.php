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
            $table->unsignedInteger('student_id');

            // Personal
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('citizen', ['wni', 'wna']);
            $table->text('address');
            $table->boolean('parent')->default(1);
            
            // Other
            $table->string('last_study')->nullable();
            $table->unsignedInteger('occupation_id')->nullable();
            $table->decimal('revenue')->nullable();
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
