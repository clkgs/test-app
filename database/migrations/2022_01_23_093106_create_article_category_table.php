<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('article_id')->constrained();
            $table->foreignUuid('category_id')->constrained();
            $table->boolean('is_primary');

            $table->unique(['category_id', 'article_id']);
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
        Schema::dropIfExists('article_category');
    }
}
