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
        Schema::table('pengujians', function (Blueprint $table) {
            // Tambahkan kolom untuk menyimpan file pengujian (JSON)
            $table->json('file_pengujian_multiple')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengujians', function (Blueprint $table) {
            $table->dropColumn('file_pengujian_multiple');
        });
    }
};