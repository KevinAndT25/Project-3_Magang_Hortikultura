<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama_pemohon', 'status_pemohon', 'perusahaan_instansi',
        'alamat', 'telepon', 'nomor_surat_permohonan', 'tanggal_surat_permohonan',
        'jenis_alsintan', 'status_alsintan', 'status_produksi', 'merek_model_tipe',
        'tahun_pembuatan', 'jumlah_unit', 'daya_maksimal', 'putaran_mesin',
        'bahan_bakar', 'sistem_pendinginan', 'dimensi', 'berat', 'kapasitas_kerja',
        'perlengkapan', 'file_surat_permohonan', 'file_akte', 'file_ktp',
        'file_npwp', 'file_nib', 'validasi_selesai', 'pengujian_selesai',
        'test_report_selesai', 'kuisioner_selesai', 'nomor_permohonan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validasi()
    {
        return $this->hasOne(Validasi::class);
    }

    public function pengujian()
    {
        return $this->hasOne(Pengujian::class);
    }

    public function testReport()
    {
        return $this->hasOne(TestReport::class);
    }

    public function kuisioner()
    {
        return $this->hasOne(Kuisioner::class);
    }

    // Cek apakah semua tahap selesai
    public function isSelesai()
    {
        return $this->validasi_selesai && $this->pengujian_selesai &&
               $this->test_report_selesai && $this->kuisioner_selesai;
    }
}