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
        Schema::create('book_author', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained('book')
                ->onDelete('CASCADE');

            $table->foreignId('author_id')
                ->constrained('author')
                ->onDelete('CASCADE');

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
        Schema::dropIfExists('book_author');
    }
};
