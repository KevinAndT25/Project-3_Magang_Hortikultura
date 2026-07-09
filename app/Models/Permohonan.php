<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'no_permohonan',  // <-- BERUBAH DARI 'nomor_permohonan'
        'status',         // <-- BARU
        'nama_pemohon', 
        'status_pemohon', 
        'perusahaan_instansi',
        'alamat', 
        'telepon', 
        'nomor_surat_permohonan', 
        'tanggal_surat_permohonan',
        'jenis_alsintan', 
        'status_alsintan', 
        'status_produksi', 
        'merek_model_tipe',
        'tahun_pembuatan', 
        'jumlah_unit', 
        'daya_maksimal', 
        'putaran_mesin',
        'bahan_bakar', 
        'sistem_pendinginan', 
        'dimensi', 
        'berat', 
        'kapasitas_kerja',
        'perlengkapan', 
        'surat_permohonan',  // <-- BERUBAH
        'akte',              // <-- BERUBAH
        'ktp',               // <-- BERUBAH
        'npwp',              // <-- BERUBAH
        'nib',               // <-- BERUBAH
        'validasi_selesai', 
        'pengujian_selesai',
        'test_report_selesai', 
        'kuisioner_selesai'
    ];
    // protected $fillable = [
    //     'user_id', 'no_permohonan', 'status', 'nama_pemohon',
    //     'status_pemohon', 'perusahaan_instansi', 'alamat', 'telepon',
    //     'nomor_surat_permohonan', 'tanggal_surat_permohonan', 'jenis_alsintan', 'status_alsintan',
    //     'status_produksi', 'merek_model_tipe', 'tahun_pembuatan', 'jumlah_unit',
    //     'daya_maksimal', 'putaran_mesin', 'bahan_bakar', 'sistem_pendinginan',
    //     'dimensi', 'berat', 'kapasitas_kerja', 'perlengkapan',
    //     'surat_permohonan', 'akte', 'ktp', 'npwp',
    //     'nib', 'validasi_selesai', 'pengujian_selesai', 'test_report_selesai',
    //     'kuisioner_selesai'
    // ];

    protected $casts = [
        'tanggal_surat_permohonan' => 'date',
        'tahun_pembuatan' => 'integer',
        'jumlah_unit' => 'integer',
        'validasi_selesai' => 'boolean',
        'pengujian_selesai' => 'boolean',
        'test_report_selesai' => 'boolean',
        'kuisioner_selesai' => 'boolean',
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

    // ============================================
    // STATUS CHECK METHODS
    // ============================================

    /**
     * Cek apakah permohonan adalah draft
     */
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    /**
     * Cek apakah permohonan aktif (sudah disubmit tapi belum selesai)
     */
    public function isAktif()
    {
        return $this->status === 'aktif';
    }

    /**
     * Cek apakah permohonan sudah selesai semua tahap
     */
    public function isSelesai()
    {
        return $this->status === 'selesai' || 
               ($this->validasi_selesai && 
                $this->pengujian_selesai &&
                $this->test_report_selesai && 
                $this->kuisioner_selesai);
    }

    /**
     * Cek apakah permohonan bisa diedit (hanya draft)
     */
    public function isEditable()
    {
        return $this->isDraft();
    }

    /**
     * Cek apakah permohonan bisa disubmit (draft dengan data lengkap)
     */
    public function isSubmittable()
    {
        if (!$this->isDraft()) {
            return false;
        }

        // Cek field wajib
        $requiredFields = [
            'nama_pemohon', 'status_pemohon', 'perusahaan_instansi', 'alamat',
            'telepon', 'nomor_surat_permohonan', 'tanggal_surat_permohonan',
            'jenis_alsintan', 'status_alsintan', 'status_produksi',
            'merek_model_tipe', 'jumlah_unit'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        // Cek file berdasarkan status pemohon
        if (empty($this->surat_permohonan)) {
            return false;
        }

        if ($this->status_pemohon === 'UMKM' && empty($this->ktp)) {
            return false;
        }

        if ($this->status_pemohon === 'Produsen') {
            if (empty($this->ktp) || empty($this->akte) || 
                empty($this->npwp) || empty($this->nib)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Mendapatkan daftar field yang belum lengkap untuk submit
     */
    public function getMissingFields()
    {
        $missing = [];

        $requiredFields = [
            'nama_pemohon' => 'Nama Pemohon',
            'status_pemohon' => 'Status Pemohon',
            'perusahaan_instansi' => 'Perusahaan/Instansi',
            'alamat' => 'Alamat',
            'telepon' => 'Nomor Telepon',
            'nomor_surat_permohonan' => 'Nomor Surat',
            'tanggal_surat_permohonan' => 'Tanggal Surat',
            'jenis_alsintan' => 'Jenis Alsintan',
            'status_alsintan' => 'Status Alsintan',
            'status_produksi' => 'Status Produksi',
            'merek_model_tipe' => 'Merek/Model/Tipe',
            'jumlah_unit' => 'Jumlah Unit'
        ];

        foreach ($requiredFields as $field => $label) {
            if (empty($this->$field)) {
                $missing[] = $label;
            }
        }

        if (empty($this->surat_permohonan)) {
            $missing[] = 'Surat Permohonan';
        }

        if ($this->status_pemohon === 'UMKM' && empty($this->ktp)) {
            $missing[] = 'KTP Pemohon';
        }

        if ($this->status_pemohon === 'Produsen') {
            if (empty($this->ktp)) $missing[] = 'KTP Pemohon';
            if (empty($this->akte)) $missing[] = 'Akte Perusahaan';
            if (empty($this->npwp)) $missing[] = 'NPWP';
            if (empty($this->nib)) $missing[] = 'NIB';
        }

        return $missing;
    }

    // ============================================
    // SCOPE METHODS
    // ============================================

    /**
     * Scope untuk filter draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope untuk filter aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope untuk filter permohonan yang belum selesai (aktif + draft)
     */
    public function scopeBelumSelesai($query)
    {
        return $query->whereIn('status', ['draft', 'aktif']);
    }

    /**
     * Scope untuk filter permohonan milik user tertentu
     */
    public function scopeMilikUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Mendapatkan label status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Mendapatkan badge class untuk status
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'draft' => 'badge-secondary',
            'aktif' => 'badge-warning',
            'selesai' => 'badge-success'
        ];

        return $classes[$this->status] ?? 'badge-secondary';
    }

    /**
     * Mendapatkan icon untuk status
     */
    public function getStatusIconAttribute()
    {
        $icons = [
            'draft' => 'bi-file-earmark',
            'aktif' => 'bi-hourglass-split',
            'selesai' => 'bi-check-circle'
        ];

        return $icons[$this->status] ?? 'bi-file-earmark';
    }

    /**
     * Cek apakah user tertentu bisa mengakses permohonan ini
     */
    public function isAccessibleBy($userId)
    {
        return $this->user_id === $userId;
    }

    /**
     * Cek apakah admin bisa melihat permohonan ini
     */
    public function isVisibleToAdmin()
    {
        return !$this->isDraft();
    }

    /**
     * Mendapatkan progress tahapan dalam persen
     */
    public function getProgressAttribute()
    {
        $tahapan = [
            'validasi_selesai',
            'pengujian_selesai',
            'test_report_selesai',
            'kuisioner_selesai'
        ];

        $completed = 0;
        foreach ($tahapan as $tahap) {
            if ($this->$tahap) {
                $completed++;
            }
        }

        return round(($completed / count($tahapan)) * 100);
    }

    /**
     * Mendapatkan daftar tahapan yang sudah selesai
     */
    public function getCompletedStagesAttribute()
    {
        $stages = [];
        $stageNames = [
            'validasi_selesai' => 'Validasi',
            'pengujian_selesai' => 'Pengujian',
            'test_report_selesai' => 'Test Report',
            'kuisioner_selesai' => 'Kuisioner'
        ];

        foreach ($stageNames as $field => $name) {
            if ($this->$field) {
                $stages[] = $name;
            }
        }

        return $stages;
    }

    /**
     * Mendapatkan daftar tahapan yang belum selesai
     */
    public function getIncompleteStagesAttribute()
    {
        $stages = [];
        $stageNames = [
            'validasi_selesai' => 'Validasi',
            'pengujian_selesai' => 'Pengujian',
            'test_report_selesai' => 'Test Report',
            'kuisioner_selesai' => 'Kuisioner'
        ];

        foreach ($stageNames as $field => $name) {
            if (!$this->$field) {
                $stages[] = $name;
            }
        }

        return $stages;
    }

    /**
     * Cek apakah semua file sudah diupload
     */
    public function hasAllFiles()
    {
        $requiredFiles = ['surat_permohonan'];
        
        if ($this->status_pemohon === 'UMKM') {
            $requiredFiles[] = 'ktp';
        } elseif ($this->status_pemohon === 'Produsen') {
            $requiredFiles = array_merge($requiredFiles, ['ktp', 'akte', 'npwp', 'nib']);
        }

        foreach ($requiredFiles as $file) {
            if (empty($this->$file)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get URL file dengan path lengkap
     */
    public function getFileUrlAttribute($fileField)
    {
        if (!empty($this->$fileField)) {
            return asset('storage/' . $this->$fileField);
        }
        return null;
    }

    /**
     * Mendapatkan semua file yang diupload
     */
    public function getUploadedFilesAttribute()
    {
        $files = [];
        $fileFields = [
            'surat_permohonan' => 'Surat Permohonan',
            'ktp' => 'KTP',
            'akte' => 'Akte Perusahaan',
            'npwp' => 'NPWP',
            'nib' => 'NIB'
        ];

        foreach ($fileFields as $field => $label) {
            if (!empty($this->$field)) {
                $files[] = [
                    'label' => $label,
                    'field' => $field,
                    'path' => $this->$field,
                    'url' => asset('storage/' . $this->$field),
                    'filename' => basename($this->$field)
                ];
            }
        }

        return $files;
    }
}