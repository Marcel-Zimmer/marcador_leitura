<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('id');
            $table ->string('id_google_books')->nullable();
            $table ->string('title')->nullable();
            $table->string('authors')->nullable();
            $table->string('publisher')->nullable();
            $table->string('publishedDate')->nullable();
            $table->text('description')->nullable();
            $table->integer('pageCount')->nullable();
            $table->string('categories')->nullable();
            $table->string('smallThumbnail')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('language')->nullable();
            $table->float('price')->nullable();
            $table->string('currencyCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
