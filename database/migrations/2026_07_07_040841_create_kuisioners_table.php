<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kuisioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->onDelete('cascade');
            // Profil Responden
            $table->string('nama_responden');
            $table->string('telepon_responden');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('usia');
            $table->string('pendidikan_terakhir');
            $table->string('nama_perusahaan_instansi');
            $table->text('alamat_perusahaan');
            $table->string('jabatan');
            $table->integer('lama_bekerja_tahun');
            // Informasi umum
            $table->boolean('pengujian_pertama');
            $table->integer('pengujian_ke')->nullable(); // jika tidak pertama
            $table->enum('mewakili', ['diri_sendiri', 'perusahaan']);
            $table->string('terakhir_mengajukan')->nullable();
            $table->enum('unit_layanan', ['uji_awal', 'uji_ulang', 'uji_perpanjangan']);
            $table->integer('hari_laporan_keluar');
            // Servqual (5 pertanyaan skala 1-5)
            $table->integer('servqual_1');
            $table->integer('servqual_2');
            $table->integer('servqual_3');
            $table->integer('servqual_4');
            $table->integer('servqual_5');
            $table->text('kesan_pesan')->nullable();
            // Kepuasan umum
            $table->enum('kepuasan_umum', ['sangat_tidak_puas', 'tidak_puas', 'netral', 'puas', 'sangat_puas']);
            $table->enum('rekomendasi', ['sangat_tidak', 'tidak', 'terserah', 'merekomendasikan', 'sangat_merekomendasikan']);
            $table->text('ide_saran')->nullable();
            $table->boolean('is_submit')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kuisioners');
    }
};