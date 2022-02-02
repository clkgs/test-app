<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content')->fulltext();
            $table->foreignUuid('article_id')->constrained();
            $table->enum('type', ['html']);
            $table->json('attributes');

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
        Schema::dropIfExists('contents');
    }
}
