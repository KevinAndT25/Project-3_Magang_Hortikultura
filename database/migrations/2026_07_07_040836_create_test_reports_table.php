<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->onDelete('cascade');
            $table->json('file_test_report_multiple')->nullable(); // simpan array path
            $table->boolean('is_submit')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_reports');
    }
};