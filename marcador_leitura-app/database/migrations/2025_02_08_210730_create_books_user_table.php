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
        Schema::create('books_user', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('id_book')->constrained('books')->onDelete('cascade')->nullable();
            $table->integer('note')->nullable();
            $table->string('status')->nullable();
            $table->text('resume')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_user');
    }
};
