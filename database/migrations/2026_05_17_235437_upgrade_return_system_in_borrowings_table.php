<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {

            // hapus field lama
            $table->dropColumn([
                'return_condition',
                'return_note',
                'return_photo',
            ]);

            // field baru multi image
            $table->json('return_photos')->nullable()->after('return_date');
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {

            $table->string('return_condition')->nullable();
            $table->text('return_note')->nullable();
            $table->string('return_photo')->nullable();

            $table->dropColumn('return_photos');
        });
    }
};