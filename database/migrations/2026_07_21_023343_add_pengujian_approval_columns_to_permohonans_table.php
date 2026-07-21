<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->boolean('pengujian_disetujui')->default(false)->after('kuisioner_selesai');
            $table->boolean('pengujian_ditolak')->default(false)->after('pengujian_disetujui');
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['pengujian_disetujui', 'pengujian_ditolak']);
        });
    }
};