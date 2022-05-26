<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstStudyYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_study_year', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('semester');
                                    
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
        Schema::dropIfExists('mst_study_year');
    }
}
