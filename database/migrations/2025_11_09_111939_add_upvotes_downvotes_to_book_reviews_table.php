<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('book_reviews', 'upvotes_count')) {
                $table->integer('upvotes_count')->default(0);
            }
            if (!Schema::hasColumn('book_reviews', 'downvotes_count')) {
                $table->integer('downvotes_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->dropColumn(['upvotes_count', 'downvotes_count']);
        });
    }
};
