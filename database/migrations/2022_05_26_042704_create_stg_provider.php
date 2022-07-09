<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStgProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stg_provider', function (Blueprint $table) {
            $table->id();
            $table->string('company_no')->nullable();
            $table->string('company_name');
            $table->date('company_birth_date')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone_number')->nullable();
            $table->string('owner_nip')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_birth_place')->nullable();
            $table->date('owner_birth_date')->nullable();
            $table->text('owner_address')->nullable();
            $table->string('owner_phone_number')->nullable();

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
        Schema::dropIfExists('stg_provider');
    }
}
