<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_score', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('std_lesson');
            $table->decimal('score');
            $table->enum('type', ['uh1', 'uh2', 'uh3', 'uh4', 'uts', 'uas', 'na']);
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
        Schema::dropIfExists('std_score');
    }
}
