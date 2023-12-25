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
        Schema::create('book_subject', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained('book')
                ->restrictOnDelete();

            $table->foreignId('subject_id')
                ->constrained('subject')
                ->restrictOnDelete();

            $table->unique(['book_id', 'subject_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('book_subject');
    }
};
