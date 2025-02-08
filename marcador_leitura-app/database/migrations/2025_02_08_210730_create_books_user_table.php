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
            $table->id();
            $table->timestamps();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('id_book');
            $table->foreign('id_book')->references('idBook')->on('books')->onDelete('cascade');
            $table->integer('note');
            $table->string('status');
            $table->string('resume');
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
