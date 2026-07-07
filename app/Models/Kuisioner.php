<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id', 'nama_responden', 'telepon_responden', 'jenis_kelamin',
        'usia', 'pendidikan_terakhir', 'nama_perusahaan_instansi', 'alamat_perusahaan',
        'jabatan', 'lama_bekerja_tahun', 'pengujian_pertama', 'pengujian_ke',
        'mewakili', 'terakhir_mengajukan', 'unit_layanan', 'hari_laporan_keluar',
        'servqual_1','servqual_2','servqual_3','servqual_4','servqual_5',
        'kesan_pesan', 'kepuasan_umum', 'rekomendasi', 'ide_saran', 'is_submit'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}