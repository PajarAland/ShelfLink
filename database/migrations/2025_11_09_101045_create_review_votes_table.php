<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('book_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['upvote', 'downvote']);
            $table->timestamps();

            $table->unique(['review_id', 'user_id']); // 1 user 1 vote per review
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_votes');
    }
};

