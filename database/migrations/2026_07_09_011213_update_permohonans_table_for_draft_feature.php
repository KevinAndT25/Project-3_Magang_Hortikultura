<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            // 1. Tambah kolom status
            $table->enum('status', ['draft', 'aktif', 'selesai'])->default('draft')->after('id');
            
            // 2. Ubah nama kolom file
            $table->renameColumn('file_surat_permohonan', 'surat_permohonan');
            $table->renameColumn('file_akte', 'akte');
            $table->renameColumn('file_ktp', 'ktp');
            $table->renameColumn('file_npwp', 'npwp');
            $table->renameColumn('file_nib', 'nib');
            
            // 3. Ubah nama kolom nomor permohonan
            $table->renameColumn('nomor_permohonan', 'no_permohonan');
        });
    }

    public function down()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn('status');
            
            $table->renameColumn('surat_permohonan', 'file_surat_permohonan');
            $table->renameColumn('akte', 'file_akte');
            $table->renameColumn('ktp', 'file_ktp');
            $table->renameColumn('npwp', 'file_npwp');
            $table->renameColumn('nib', 'file_nib');
            
            $table->renameColumn('no_permohonan', 'nomor_permohonan');
        });
    }
};