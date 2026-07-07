<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id', 'nomor_permohonan_uji', 'tanggal_pengujian',
        'lokasi', 'deskripsi', 'is_submit'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}