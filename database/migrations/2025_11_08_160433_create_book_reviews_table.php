<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id(); // Primary Key

            // Foreign Keys
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('book_id')
                ->constrained('books')
                ->onDelete('cascade');

            // Kolom tambahan
            $table->unsignedTinyInteger('rating'); // nilai 1-5
            $table->text('comment')->nullable();   // ulasan teks (boleh kosong)

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};
