<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id', 'file_test_report_multiple', 'is_submit'
    ];

    protected $casts = [
        'file_test_report_multiple' => 'array',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}