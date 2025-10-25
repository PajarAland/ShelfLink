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
        Schema::table('books', function (Blueprint $table) {
            $table->string('category')->nullable()->after('author');
            $table->integer('stock')->default(0)->after('published_year');
            $table->string('cover')->nullable()->after('title');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('stock');
            $table->dropColumn('cover');      
        });
    }
};
