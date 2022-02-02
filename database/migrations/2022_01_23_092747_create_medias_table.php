<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('article_id')->constrained();
            $table->enum('source', ['archive']);
            $table->string('slug', 250);
            $table->enum('type', ['image']);
            $table->json('attributes');
            $table->timestamp('published');
            $table->timestamp('modified');

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
        Schema::dropIfExists('medias');
    }
}
