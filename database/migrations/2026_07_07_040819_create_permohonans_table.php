<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pemohon
            // Data Pemohon Uji
            $table->string('nama_pemohon');
            $table->enum('status_pemohon', ['UMKM', 'Pemerintah', 'Produsen']); // sesuai dropdown
            $table->string('perusahaan_instansi')->nullable();
            $table->text('alamat');
            $table->string('telepon');
            $table->string('nomor_surat_permohonan');
            $table->date('tanggal_surat_permohonan');
            // Informasi Alsintan
            $table->string('jenis_alsintan');
            $table->enum('status_alsintan', ['prototipe', 'produk_massal', 'impor']);
            $table->enum('status_produksi', ['produk_lokal', 'impor']);
            $table->string('merek_model_tipe');
            $table->year('tahun_pembuatan');
            $table->integer('jumlah_unit');
            // Spesifikasi motor penggerak
            $table->string('daya_maksimal')->nullable();
            $table->string('putaran_mesin')->nullable();
            $table->string('bahan_bakar')->nullable();
            $table->string('sistem_pendinginan')->nullable();
            // Spesifikasi unit alat
            $table->string('dimensi')->nullable();
            $table->string('berat')->nullable();
            $table->string('kapasitas_kerja')->nullable();
            $table->string('perlengkapan')->nullable();
            // Upload file (path)
            $table->string('file_surat_permohonan')->nullable();
            $table->string('file_akte')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('file_nib')->nullable();
            // Status kelengkapan (boolean)
            $table->boolean('validasi_selesai')->default(false);
            $table->boolean('pengujian_selesai')->default(false);
            $table->boolean('test_report_selesai')->default(false);
            $table->boolean('kuisioner_selesai')->default(false);
            // Nomor permohonan otomatis (akan diisi setelah submit)
            $table->string('nomor_permohonan')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonans');
    }
};