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
            $table->string('idBook')->primary();
            $table ->string('title');
            $table->string('authors');
            $table->string('publisher');
            $table->string('publishedDate');
            $table->text('description');
            $table->integer('pageCount');
            $table->string('categories');
            $table->string('smallThumbnail');
            $table->string('thumbnail');
            $table->string('language');
            $table->float('price');
            $table->string('currencyCode');
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
