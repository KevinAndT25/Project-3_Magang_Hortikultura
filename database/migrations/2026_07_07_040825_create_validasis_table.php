<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('validasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->onDelete('cascade');
            $table->string('file_kaji_ulang'); // bisa multiple? tapi kita simpan satu path utama, atau bisa gunakan JSON. Tapi karena boleh lebih dari satu, kita simpan sebagai JSON atau gunakan tabel terpisah. Saya sarankan simpan sebagai JSON array.
            $table->json('file_kaji_ulang_multiple')->nullable(); // simpan array path
            $table->boolean('is_submit')->default(false); // menandakan sudah disubmit
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('validasis');
    }
};