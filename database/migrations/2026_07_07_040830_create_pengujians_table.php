<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->onDelete('cascade');
            $table->string('nomor_permohonan_uji')->nullable(); // diisi otomatis dari permohonan
            $table->date('tanggal_pengujian');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_submit')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengujians');
    }
};