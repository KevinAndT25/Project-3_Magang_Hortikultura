<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['pemohon', 'admin'])->default('pemohon');
            $table->string('no_hp')->nullable();
            // tambahkan kolom lain jika perlu (misal nama lengkap sudah ada)
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp']);
        });
    }
};