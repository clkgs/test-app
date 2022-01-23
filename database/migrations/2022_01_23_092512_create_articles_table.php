<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('source', ['archive']);
            $table->string('title', 255);
            $table->string('subtitle', 255);
            $table->string('slug', 255);
            $table->enum('format', ['standard']);
            $table->string('emoji', 255);
            $table->timestamp('published');
            $table->timestamp('modified');
            $table->enum('status', ['published']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
}
