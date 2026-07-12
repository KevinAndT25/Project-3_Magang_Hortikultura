@extends('layouts.app')

@section('title', 'Form Pengujian')

@section('content')
<style>
    /* Form Styling */
    .form-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px 30px;
        margin-bottom: 25px;
    }
    
    .form-section .section-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .form-section .section-subtitle {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f2f5;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #2c3e50;
        margin-bottom: 4px;
    }
    
    .form-label .required {
        color: #e74c3c;
        margin-left: 3px;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dce1e8;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1a6e4a;
        box-shadow: 0 0 0 3px rgba(26, 110, 74, 0.1);
    }
    
    .form-control[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
    }
    
    .form-control::placeholder {
        color: #b0b8c4;
        font-size: 13px;
    }
    
    /* Info Cards */
    .info-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .info-card .info-icon {
        font-size: 20px;
        color: #1a6e4a;
    }
    
    .info-card .info-label {
        font-size: 12px;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .info-card .info-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 600;
    }
    
    /* Alert Info */
    .alert-info-custom {
        background: #e8f5e9;
        border: 1px solid #27ae60;
        color: #1a6e4a;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 20px;
    }
    
    .alert-info-custom i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 2px solid #f0f2f5;
        margin-top: 10px;
    }
    
    .btn-submit-pengujian {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border: none;
        padding: 10px 35px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .btn-submit-pengujian:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(26, 110, 74, 0.4);
        color: white;
    }
    
    .btn-submit-pengujian:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-cancel {
        background: #f0f2f5;
        color: #7f8c8d;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background: #e0e5ec;
        color: #2c3e50;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-section {
            padding: 15px 18px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
        
        .info-card {
            flex-wrap: wrap;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-clipboard2-check me-2" style="color: #1a6e4a;"></i>
                    Form Pengujian
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <a href="{{ route('dashboard.admin') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Info Permohonan -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-file-earmark-text me-2" style="color: #1a6e4a;"></i>
                Detail Permohonan
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div>
                            <div class="info-label">Nomor Permohonan</div>
                            <div class="info-value">
                                {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <div class="info-label">Pemohon</div>
                            <div class="info-value">{{ $permohonan->nama_pemohon }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <div class="info-label">Alsintan</div>
                            <div class="info-value">{{ $permohonan->jenis_alsintan }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-tag"></i>
                        </div>
                        <div>
                            <div class="info-label">Merek/Tipe</div>
                            <div class="info-value">{{ $permohonan->merek_model_tipe }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <span class="badge bg-success">
                    <i class="bi bi-check-circle me-1"></i> Validasi Selesai
                </span>
                <span class="text-muted ms-2" style="font-size: 13px;">
                    {{ $permohonan->tanggal_surat_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_surat_permohonan)->format('d M Y') : '-' }}
                </span>
            </div>
        </div>

        <!-- Form Pengujian -->
        <form method="POST" action="{{ route('pengujian.store', $permohonan->id) }}" id="formPengujian">
            @csrf
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-clipboard-data me-2" style="color: #1a6e4a;"></i>
                    Form Pengujian
                </div>
                <div class="section-subtitle">
                    Berdasarkan Permohonan Uji No. <strong>{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>

                <!-- Berdasarkan Permohonan Uji No. -->
                <div class="mb-3">
                    <label for="nomor_permohonan_uji" class="form-label">
                        Berdasarkan Permohonan Uji No.
                    </label>
                    <input type="text" class="form-control" id="nomor_permohonan_uji" 
                           name="nomor_permohonan_uji" 
                           value="{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}" 
                           readonly>
                </div>

                <!-- Tanggal Pengujian -->
                <div class="mb-3">
                    <label for="tanggal_pengujian" class="form-label">
                        Tanggal Pengujian <span class="required">*</span>
                    </label>
                    <input type="date" class="form-control @error('tanggal_pengujian') is-invalid @enderror" 
                           id="tanggal_pengujian" name="tanggal_pengujian" 
                           value="{{ old('tanggal_pengujian', date('Y-m-d')) }}" required>
                    @error('tanggal_pengujian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi Pengujian -->
                <div class="mb-3">
                    <label for="lokasi" class="form-label">
                        Lokasi Pengujian <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                           id="lokasi" name="lokasi" 
                           placeholder="Contoh: Laboratorium LPMA UPTD BMSPP, Bogor"
                           value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi Pengujian -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi Pengujian
                    </label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="4"
                              placeholder="Deskripsi proses dan lingkup pengujian yang dilakukan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Info Alert -->
                <div class="alert-info-custom">
                    <i class="bi bi-info-circle"></i>
                    <strong>Informasi:</strong>
                    Data pengujian tidak dapat diedit setelah disimpan.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-section">
                <div class="form-actions">
                    <button type="submit" class="btn-submit-pengujian" id="btnSubmit">
                        <i class="bi bi-save"></i> Simpan Data Pengujian
                    </button>
                    <a href="{{ route('dashboard.admin') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPengujian');
    const btnSubmit = document.getElementById('btnSubmit');

    // ============================================
    // FORM SUBMIT
    // ============================================
    form.addEventListener('submit', function(e) {
        // Konfirmasi submit
        if (!confirm('Apakah Anda yakin ingin menyimpan data pengujian ini? Data tidak dapat diedit kembali.')) {
            e.preventDefault();
            return false;
        }
        return true;
    });

    // ============================================
    // SET DEFAULT DATE
    // ============================================
    const tanggalInput = document.getElementById('tanggal_pengujian');
    if (tanggalInput && !tanggalInput.value) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        tanggalInput.value = `${year}-${month}-${day}`;
    }
});
</script>
@endsection