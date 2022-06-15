<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_article', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('tag_id')->nullable();
            $table->enum('status', ['new', 'draft', 'publish']);
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->string('author')->nullable();
                                    
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
        Schema::dropIfExists('std_article');
    }
}
