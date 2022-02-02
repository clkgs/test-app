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
            $table->string('title', 250)->fulltext();
            $table->string('subtitle', 250);
            $table->string('slug', 250)->unique();
            $table->enum('format', ['standard']);
            $table->string('emoji', 250);
            $table->timestamp('published')->index();
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
