<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('payment_id');
            $table->string('month', 2);
            $table->year('year');
            $table->double('amount');
            $table->enum('status', ['lunas', 'belum', 'cicil']);
            $table->boolean('push_wa')->default(0);
            $table->double('installment_amount')->nullable();

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
        Schema::dropIfExists('std_payment');
    }
}
