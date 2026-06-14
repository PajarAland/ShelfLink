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
            $table->boolean('ai_damage_detected')->nullable()->after('return_photos');
            $table->float('ai_confidence')->nullable()->after('ai_damage_detected');
            $table->text('ai_damage_details')->nullable()->after('ai_confidence');
            $table->integer('ai_suggested_fine')->nullable()->after('ai_damage_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn([
                'ai_damage_detected',
                'ai_confidence',
                'ai_damage_details',
                'ai_suggested_fine',
            ]);
        });
    }
};
