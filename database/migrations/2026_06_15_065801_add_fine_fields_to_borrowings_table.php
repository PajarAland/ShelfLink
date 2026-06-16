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
        Schema::table('borrowings', function (Blueprint $table) {
            $table->integer('late_fine')->default(0)->after('ai_suggested_fine');
            $table->integer('damage_fine')->default(0)->after('late_fine');
            $table->integer('total_fine')->default(0)->after('damage_fine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['late_fine', 'damage_fine', 'total_fine']);
        });
    }
};
