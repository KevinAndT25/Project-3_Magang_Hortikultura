<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id', 'file_kaji_ulang_multiple', 'is_submit'
    ];

    protected $casts = [
        'file_kaji_ulang_multiple' => 'array',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}