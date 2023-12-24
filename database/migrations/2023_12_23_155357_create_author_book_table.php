<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained('book')
                ->restrictOnDelete();

            $table->foreignId('author_id')
                ->constrained('author')
                ->restrictOnDelete();

            $table->unique(['book_id', 'author_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};
