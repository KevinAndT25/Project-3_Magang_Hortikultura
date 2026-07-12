<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'no_permohonan',  
        'status',         
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
        'dimensi_p', 'dimensi_l', 'dimensi_t',  
        'berat', 
        'kapasitas_kerja',
        'perlengkapan', 
        'surat_permohonan',  
        'akte',              
        'ktp',               
        'npwp',              
        'nib',               
        'validasi_selesai', 
        'pengujian_selesai',
        'test_report_selesai', 
        'kuisioner_selesai'
    ];

    protected $casts = [
        'tanggal_surat_permohonan' => 'date',
        'tahun_pembuatan' => 'integer',
        'jumlah_unit' => 'integer',
        'validasi_selesai' => 'boolean',
        'pengujian_selesai' => 'boolean',
        'test_report_selesai' => 'boolean',
        'kuisioner_selesai' => 'boolean',
    ];

    // Accessor untuk menggabungkan dimensi 
    public function getDimensiAttribute()
    {
        $parts = [];
        if ($this->dimensi_p) $parts[] = $this->dimensi_p;
        if ($this->dimensi_l) $parts[] = $this->dimensi_l;
        if ($this->dimensi_t) $parts[] = $this->dimensi_t;
        
        return !empty($parts) ? implode(' x ', $parts) : null;
    }

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

    // ============================================
    // HELPER METHODS (Tambahan untuk File)
    // ============================================

    /**
     * Cek apakah file ada di storage
     */
    public function fileExists($field)
    {
        if (empty($this->$field)) {
            return false;
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($this->$field);
    }

    /**
     * Mendapatkan URL file
     */
    public function getFileUrl($field)
    {
        if (empty($this->$field)) {
            return null;
        }
        return asset('storage/' . $this->$field);
    }

    /**
     * Mendapatkan icon Bootstrap untuk file berdasarkan ekstensi
     */
    public function getFileIcon($field)
    {
        if (empty($this->$field)) {
            return 'bi-file-earmark';
        }
        
        $extension = strtolower(pathinfo($this->$field, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => 'bi-file-earmark-pdf',
            'jpg' => 'bi-file-earmark-image',
            'jpeg' => 'bi-file-earmark-image',
            'png' => 'bi-file-earmark-image',
            'gif' => 'bi-file-earmark-image',
            'svg' => 'bi-file-earmark-image',
            'webp' => 'bi-file-earmark-image',
            'bmp' => 'bi-file-earmark-image',
            'doc' => 'bi-file-earmark-word',
            'docx' => 'bi-file-earmark-word',
            'xls' => 'bi-file-earmark-excel',
            'xlsx' => 'bi-file-earmark-excel',
            'ppt' => 'bi-file-earmark-slides',
            'pptx' => 'bi-file-earmark-slides',
            'zip' => 'bi-file-earmark-zip',
            'rar' => 'bi-file-earmark-zip',
            '7z' => 'bi-file-earmark-zip',
            'txt' => 'bi-file-earmark-text',
            'csv' => 'bi-file-earmark-text',
            'json' => 'bi-file-earmark-code',
            'xml' => 'bi-file-earmark-code',
            'html' => 'bi-file-earmark-code',
            'css' => 'bi-file-earmark-code',
            'js' => 'bi-file-earmark-code',
            'php' => 'bi-file-earmark-code',
        ];
        
        return $icons[$extension] ?? 'bi-file-earmark';
    }

    /**
     * Mendapatkan label file yang sudah diupload
     */
    public function getFileLabel($field)
    {
        $labels = [
            'surat_permohonan' => 'Surat Permohonan',
            'ktp' => 'KTP Pemohon',
            'akte' => 'Akte Perusahaan',
            'npwp' => 'NPWP',
            'nib' => 'NIB'
        ];
        
        return $labels[$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    /**
     * Mendapatkan semua file yang diupload dengan informasi lengkap
     */
    public function getFilesInfoAttribute()
    {
        $fileFields = ['surat_permohonan', 'ktp', 'akte', 'npwp', 'nib'];
        $files = [];
        
        foreach ($fileFields as $field) {
            if (!empty($this->$field)) {
                $files[] = [
                    'field' => $field,
                    'label' => $this->getFileLabel($field),
                    'path' => $this->$field,
                    'url' => $this->getFileUrl($field),
                    'icon' => $this->getFileIcon($field),
                    'exists' => $this->fileExists($field),
                    'filename' => basename($this->$field),
                    'extension' => strtolower(pathinfo($this->$field, PATHINFO_EXTENSION)),
                ];
            }
        }
        
        return $files;
    }

    /**
     * Cek apakah permohonan memiliki file
     */
    public function hasFiles()
    {
        $fileFields = ['surat_permohonan', 'ktp', 'akte', 'npwp', 'nib'];
        
        foreach ($fileFields as $field) {
            if (!empty($this->$field)) {
                return true;
            }
        }
        
        return false;
    }
}