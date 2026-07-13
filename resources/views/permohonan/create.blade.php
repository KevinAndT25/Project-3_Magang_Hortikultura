{{-- resources/views/permohonan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Form Permohonan Baru')

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
    
    .form-section .section-number {
        display: inline-block;
        background: #1a6e4a;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        text-align: center;
        line-height: 28px;
        font-size: 14px;
        font-weight: 700;
        margin-right: 10px;
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
    
    .form-control::placeholder {
        color: #b0b8c4;
        font-size: 13px;
    }
    
    .form-text {
        font-size: 12px;
        color: #95a5a6;
        margin-top: 4px;
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed #dce1e8;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #fafbfc;
    }
    
    .upload-area:hover {
        border-color: #1a6e4a;
        background: #f0f9f4;
    }
    
    .upload-area .upload-icon {
        font-size: 32px;
        color: #b0b8c4;
        margin-bottom: 8px;
    }
    
    .upload-area .upload-text {
        color: #7f8c8d;
        font-size: 13px;
    }
    
    .upload-area .upload-text strong {
        color: #1a6e4a;
    }
    
    .upload-area .upload-formats {
        font-size: 11px;
        color: #b0b8c4;
        margin-top: 4px;
    }
    
    /* File List */
    .file-list {
        margin-top: 10px;
    }
    
    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 5px;
    }
    
    .file-item .file-name {
        font-size: 13px;
        color: #2c3e50;
    }
    
    .file-item .file-size {
        font-size: 12px;
        color: #95a5a6;
    }
    
    .file-item .btn-remove-file {
        color: #e74c3c;
        border: none;
        background: none;
        padding: 0 5px;
        cursor: pointer;
    }
    
    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 2px solid #f0f2f5;
    }
    
    .btn-draft {
        background: #95a5a6;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .btn-draft:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        color: white;
    }
    
    .btn-submit {
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
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(26, 110, 74, 0.4);
        color: white;
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
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-file-earmark-plus me-2" style="color: #1a6e4a;"></i>
                    Form Permohonan Baru
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    Laboratorium Penguji Mutu Alsintan UPTD BMSPP
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('permohonan.store') }}" enctype="multipart/form-data" id="formPermohonan">
            @csrf
            
            <!-- ============================================ -->
            <!-- I. DATA PEMOHON UJI -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">I</span>
                    Data Pemohon Uji
                </div>
                <div class="section-subtitle">
                    Isi data identitas pemohon <strong>– tidak menggunakan data akun</strong>
                </div>
                
                <div class="row g-3">
                    {{-- Hidden Input User account --}}
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="col-md-6">
                        <label for="nama_pemohon" class="form-label">
                            Nama Pemohon Uji <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror" 
                               id="nama_pemohon" name="nama_pemohon" 
                               placeholder="Nama lengkap pemohon"
                               value="{{ old('nama_pemohon', $user->name ?? '') }}" required>
                        @error('nama_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status_pemohon" class="form-label">
                            Status Pemohon <span class="required">*</span>
                        </label>
                        <select class="form-select @error('status_pemohon') is-invalid @enderror" 
                                id="status_pemohon" name="status_pemohon" required>
                            <option value="">-- Pilih Status Pemohon --</option>
                            <option value="UMKM" {{ old('status_pemohon') == 'UMKM' ? 'selected' : '' }}>
                                Bengkel Pengrajin Alsintan (UMKM) / Pembeli / Pengguna
                            </option>
                            <option value="Pemerintah" {{ old('status_pemohon') == 'Pemerintah' ? 'selected' : '' }}>
                                Instansi Pemerintah
                            </option>
                            <option value="Produsen" {{ old('status_pemohon') == 'Produsen' ? 'selected' : '' }}>
                                Produsen / Distributor / Penyedia
                            </option>
                        </select>
                        @error('status_pemohon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="perusahaan_instansi" class="form-label">
                            Perusahaan/Instansi Pemohon <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('perusahaan_instansi') is-invalid @enderror" 
                               id="perusahaan_instansi" name="perusahaan_instansi" 
                               placeholder="Nama perusahaan atau instansi"
                               value="{{ old('perusahaan_instansi') }}" required>
                        @error('perusahaan_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">
                            Alamat Lengkap Pemohon <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" 
                               id="alamat" name="alamat" 
                               placeholder="Alamat lengkap"
                               value="{{ old('alamat') }}" required>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="telepon" class="form-label">
                            Nomor Telepon Pemohon <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                               id="telepon" name="telepon" 
                               placeholder="08xxxxxxxxx"
                               value="{{ old('telepon', $user->no_hp ?? '') }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="nomor_surat_permohonan" class="form-label">
                            Nomor Surat Pemohon <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('nomor_surat_permohonan') is-invalid @enderror" 
                               id="nomor_surat_permohonan" name="nomor_surat_permohonan" 
                               placeholder="001/XX/2024"
                               value="{{ old('nomor_surat_permohonan') }}" required>
                        @error('nomor_surat_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="tanggal_surat_permohonan" class="form-label">
                            Tanggal Surat <span class="required">*</span>
                        </label>
                        <input type="date" class="form-control @error('tanggal_surat_permohonan') is-invalid @enderror" 
                               id="tanggal_surat_permohonan" name="tanggal_surat_permohonan" 
                               value="{{ old('tanggal_surat_permohonan', date('Y-m-d')) }}" required>
                        @error('tanggal_surat_permohonan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- II. INFORMASI ALSINTAN -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">II</span>
                    Informasi Alsintan yang akan Diuji
                </div>
                <div class="section-subtitle">
                    Data teknis alat dan mesin pertanian
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="jenis_alsintan" class="form-label">
                            Jenis Alsintan <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('jenis_alsintan') is-invalid @enderror" 
                               id="jenis_alsintan" name="jenis_alsintan" 
                               placeholder="Contoh: Traktor Tangan, Pompa Semprot"
                               value="{{ old('jenis_alsintan') }}" required>
                        @error('jenis_alsintan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status_alsintan" class="form-label">
                            Status Alsintan <span class="required">*</span>
                        </label>
                        <select class="form-select @error('status_alsintan') is-invalid @enderror" 
                                id="status_alsintan" name="status_alsintan" required>
                            <option value="">-- Pilih --</option>
                            <option value="prototipe" {{ old('status_alsintan') == 'prototipe' ? 'selected' : '' }}>Prototipe</option>
                            <option value="produk_massal" {{ old('status_alsintan') == 'produk_massal' ? 'selected' : '' }}>Produk Massal</option>
                            <option value="impor" {{ old('status_alsintan') == 'impor' ? 'selected' : '' }}>Impor</option>
                        </select>
                        @error('status_alsintan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status_produksi" class="form-label">
                            Status Produksi <span class="required">*</span>
                        </label>
                        <select class="form-select @error('status_produksi') is-invalid @enderror" 
                                id="status_produksi" name="status_produksi" required>
                            <option value="">-- Pilih --</option>
                            <option value="produk_lokal" {{ old('status_produksi') == 'produk_lokal' ? 'selected' : '' }}>Produk Lokal</option>
                            <option value="impor" {{ old('status_produksi') == 'impor' ? 'selected' : '' }}>Impor</option>
                        </select>
                        @error('status_produksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="merek_model_tipe" class="form-label">
                            Merek/Model/Tipe <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('merek_model_tipe') is-invalid @enderror" 
                               id="merek_model_tipe" name="merek_model_tipe" 
                               placeholder="Contoh: Quick TL800"
                               value="{{ old('merek_model_tipe') }}" required>
                        @error('merek_model_tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="tahun_pembuatan" class="form-label">
                            Tahun Pembuatan
                        </label>
                        <input type="number" class="form-control @error('tahun_pembuatan') is-invalid @enderror" 
                               id="tahun_pembuatan" name="tahun_pembuatan" 
                               placeholder="2024"
                               min="1900" max="{{ date('Y') }}"
                               value="{{ old('tahun_pembuatan', date('Y')) }}">
                        @error('tahun_pembuatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="jumlah_unit" class="form-label">
                            Jumlah Alsintan yang Diuji <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" 
                               id="jumlah_unit" name="jumlah_unit" 
                               placeholder="0"
                               min="1"
                               value="{{ old('jumlah_unit', 1) }}" required>
                        <div class="form-text">unit</div>
                        @error('jumlah_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Spesifikasi Motor Penggerak -->
                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-3">SPESIFIKASI MOTOR PENGGERAK</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="daya_maksimal" class="form-label">
                                Daya Maksimal
                            </label>
                            <input type="text" class="form-control @error('daya_maksimal') is-invalid @enderror" 
                                id="daya_maksimal" name="daya_maksimal" 
                                placeholder="Contoh: 22 kW atau 30 HP"
                                value="{{ old('daya_maksimal') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Isi dengan angka dan satuan (contoh: 22 kW / 30 HP)
                            </div>
                            @error('daya_maksimal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="putaran_mesin" class="form-label">
                                Putaran Mesin
                            </label>
                            <input type="text" class="form-control @error('putaran_mesin') is-invalid @enderror" 
                                id="putaran_mesin" name="putaran_mesin" 
                                placeholder="Contoh: 2400 RPM"
                                value="{{ old('putaran_mesin') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Isi dengan angka dan satuan RPM (contoh: 2400 RPM)
                            </div>
                            @error('putaran_mesin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="bahan_bakar" class="form-label">
                                Bahan Bakar
                            </label>
                            <input type="text" class="form-control @error('bahan_bakar') is-invalid @enderror" 
                                id="bahan_bakar" name="bahan_bakar" 
                                placeholder="Contoh: Solar / Bensin / Diesel"
                                value="{{ old('bahan_bakar') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Jenis bahan bakar yang digunakan
                            </div>
                            @error('bahan_bakar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="sistem_pendinginan" class="form-label">
                                Sistem Pendinginan
                            </label>
                            <input type="text" class="form-control @error('sistem_pendinginan') is-invalid @enderror" 
                                id="sistem_pendinginan" name="sistem_pendinginan" 
                                placeholder="Contoh: Udara / Air"
                                value="{{ old('sistem_pendinginan') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Sistem pendinginan mesin
                            </div>
                            @error('sistem_pendinginan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Spesifikasi Unit Alat -->
                <div class="mt-4">
                    <h6 class="fw-bold text-dark mb-3">SPESIFIKASI UNIT ALAT</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="dimensi" class="form-label">
                                Dimensi (P x L x T)
                            </label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="text" class="form-control @error('dimensi_p') is-invalid @enderror" 
                                        id="dimensi_p" name="dimensi_p" 
                                        placeholder="P"
                                        value="{{ old('dimensi_p') }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control @error('dimensi_l') is-invalid @enderror" 
                                        id="dimensi_l" name="dimensi_l" 
                                        placeholder="L"
                                        value="{{ old('dimensi_l') }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control @error('dimensi_t') is-invalid @enderror" 
                                        id="dimensi_t" name="dimensi_t" 
                                        placeholder="T"
                                        value="{{ old('dimensi_t') }}">
                                </div>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Isi dengan angka dan satuan per dimensi (contoh: 220 cm, 85 cm, 115 cm)
                            </div>
                            @error('dimensi_p')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('dimensi_l')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('dimensi_t')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="berat" class="form-label">
                                Berat
                            </label>
                            <input type="text" class="form-control @error('berat') is-invalid @enderror" 
                                id="berat" name="berat" 
                                placeholder="Contoh: 150 kg"
                                value="{{ old('berat') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Isi dengan angka dan satuan berat (contoh: 150 kg)
                            </div>
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="kapasitas_kerja" class="form-label">
                                Kapasitas Kerja
                            </label>
                            <input type="text" class="form-control @error('kapasitas_kerja') is-invalid @enderror" 
                                id="kapasitas_kerja" name="kapasitas_kerja" 
                                placeholder="Contoh: 0.08 - 0.12 ha/jam"
                                value="{{ old('kapasitas_kerja') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Isi dengan rentang kapasitas kerja dan satuan (contoh: 0.08 - 0.12 ha/jam)
                            </div>
                            @error('kapasitas_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="perlengkapan" class="form-label">
                                Perlengkapan
                            </label>
                            <input type="text" class="form-control @error('perlengkapan') is-invalid @enderror" 
                                id="perlengkapan" name="perlengkapan" 
                                placeholder="Contoh: Bajak / Garu / Rotari"
                                value="{{ old('perlengkapan') }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Perlengkapan yang disertakan
                            </div>
                            @error('perlengkapan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- III. PERSYARATAN PERMOHONAN UJI -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">III</span>
                    Persyaratan Permohonan Uji
                </div>
                <div class="section-subtitle">
                    Dokumen yang diperlukan untuk: Bengkel Pengrajin Alsintan (UMKM) / Pembeli / Pengguna
                </div>
                
                <!-- Upload Surat (selalu muncul) -->
                <div class="mb-3" id="field-surat">
                    <label for="file_surat_permohonan" class="form-label">
                        Surat Permohonan Pengujian <span class="required">*</span>
                    </label>
                    <div class="upload-area" onclick="document.getElementById('file_surat_permohonan').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag and drop
                        </div>
                        <div class="upload-formats">
                            Format: PDF / JPG / PNG (Maks. 5MB)
                        </div>
                    </div>
                    <input type="file" class="d-none" id="file_surat_permohonan" 
                           name="file_surat_permohonan" 
                           accept=".pdf,.jpg,.jpeg,.png" required>
                    <div id="file_surat_info" class="file-list"></div>
                    @error('file_surat_permohonan')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Upload KTP (UMKM & Produsen) -->
                <div class="mb-3 d-none" id="field-ktp">
                    <label for="file_ktp" class="form-label">
                        KTP Pemohon <span class="required">*</span>
                    </label>
                    <div class="upload-area" onclick="document.getElementById('file_ktp').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag and drop
                        </div>
                        <div class="upload-formats">
                            Format: PDF / JPG / PNG (Maks. 5MB)
                        </div>
                    </div>
                    <input type="file" class="d-none" id="file_ktp" 
                           name="file_ktp" 
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div id="file_ktp_info" class="file-list"></div>
                    @error('file_ktp')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Upload Akte (Produsen) -->
                <div class="mb-3 d-none" id="field-akte">
                    <label for="file_akte" class="form-label">
                        Akte Pendirian Perusahaan dan Perubahannya <span class="required">*</span>
                    </label>
                    <div class="upload-area" onclick="document.getElementById('file_akte').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag and drop
                        </div>
                        <div class="upload-formats">
                            Format: PDF / JPG / PNG (Maks. 5MB)
                        </div>
                    </div>
                    <input type="file" class="d-none" id="file_akte" 
                           name="file_akte" 
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div id="file_akte_info" class="file-list"></div>
                    @error('file_akte')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Upload NPWP (Produsen) -->
                <div class="mb-3 d-none" id="field-npwp">
                    <label for="file_npwp" class="form-label">
                        NPWP <span class="required">*</span>
                    </label>
                    <div class="upload-area" onclick="document.getElementById('file_npwp').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag and drop
                        </div>
                        <div class="upload-formats">
                            Format: PDF / JPG / PNG (Maks. 5MB)
                        </div>
                    </div>
                    <input type="file" class="d-none" id="file_npwp" 
                           name="file_npwp" 
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div id="file_npwp_info" class="file-list"></div>
                    @error('file_npwp')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Upload NIB (Produsen) -->
                <div class="mb-3 d-none" id="field-nib">
                    <label for="file_nib" class="form-label">
                        NIB (Nomor Induk Berusaha) <span class="required">*</span>
                    </label>
                    <div class="upload-area" onclick="document.getElementById('file_nib').click()">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag and drop
                        </div>
                        <div class="upload-formats">
                            Format: PDF / JPG / PNG (Maks. 5MB)
                        </div>
                    </div>
                    <input type="file" class="d-none" id="file_nib" 
                           name="file_nib" 
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div id="file_nib_info" class="file-list"></div>
                    @error('file_nib')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ============================================ -->
            <!-- FORM ACTIONS -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="form-actions">
                    <a href="{{ route('dashboard.pemohon') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit" name="action" value="draft" class="btn-draft" id="btnDraft">
                        <i class="bi bi-file-earmark"></i> Simpan sebagai Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn-submit" id="btnSubmit">
                        <i class="bi bi-send"></i> Submit Permohonan
                    </button>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Draft:</strong> Permohonan disimpan dan dapat diedit kembali. 
                        <strong>Submit:</strong> Permohonan dikirim ke admin dan tidak dapat diubah.
                    </small>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // LOGIC: Dynamic Upload Fields berdasarkan Status Pemohon
        // ============================================
        const statusSelect = document.getElementById('status_pemohon');
        const fieldSurat = document.getElementById('field-surat');
        const fieldKtp = document.getElementById('field-ktp');
        const fieldAkte = document.getElementById('field-akte');
        const fieldNpwp = document.getElementById('field-npwp');
        const fieldNib = document.getElementById('field-nib');
        
        // File inputs
        const fileSurat = document.getElementById('file_surat_permohonan');
        const fileKtp = document.getElementById('file_ktp');
        const fileAkte = document.getElementById('file_akte');
        const fileNpwp = document.getElementById('file_npwp');
        const fileNib = document.getElementById('file_nib');
        
        function updateFields() {
            const status = statusSelect.value;
            
            // Reset semua
            fieldSurat.classList.remove('d-none');
            fieldKtp.classList.add('d-none');
            fieldAkte.classList.add('d-none');
            fieldNpwp.classList.add('d-none');
            fieldNib.classList.add('d-none');
            
            // Reset required
            fileSurat.required = true;
            fileKtp.required = false;
            fileAkte.required = false;
            fileNpwp.required = false;
            fileNib.required = false;
            
            if (status === 'UMKM') {
                fieldKtp.classList.remove('d-none');
                fileKtp.required = true;
            } else if (status === 'Produsen') {
                fieldKtp.classList.remove('d-none');
                fieldAkte.classList.remove('d-none');
                fieldNpwp.classList.remove('d-none');
                fieldNib.classList.remove('d-none');
                fileKtp.required = true;
                fileAkte.required = true;
                fileNpwp.required = true;
                fileNib.required = true;
            }
            // Pemerintah: hanya surat
        }
        
        statusSelect.addEventListener('change', updateFields);
        updateFields();
        
        // ============================================
        // FILE UPLOAD HANDLER (Preview)
        // ============================================
        function setupFileUpload(fileInput, infoContainerId) {
            const infoContainer = document.getElementById(infoContainerId);
            
            fileInput.addEventListener('change', function() {
                infoContainer.innerHTML = '';
                
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <span class="file-name">
                            <i class="bi bi-file-earmark me-2" style="color: #1a6e4a;"></i>
                            ${file.name}
                        </span>
                        <span class="file-size">${fileSize} MB</span>
                        <button type="button" class="btn-remove-file" onclick="removeFile('${fileInput.id}', '${infoContainerId}')">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    `;
                    infoContainer.appendChild(fileItem);
                }
            });
        }
        
        // Setup semua file upload
        setupFileUpload(fileSurat, 'file_surat_info');
        setupFileUpload(fileKtp, 'file_ktp_info');
        setupFileUpload(fileAkte, 'file_akte_info');
        setupFileUpload(fileNpwp, 'file_npwp_info');
        setupFileUpload(fileNib, 'file_nib_info');
        
        // ============================================
        // REMOVE FILE FUNCTION
        // ============================================
        window.removeFile = function(inputId, containerId) {
            const fileInput = document.getElementById(inputId);
            const container = document.getElementById(containerId);
            
            fileInput.value = '';
            container.innerHTML = '';
        };
        
        // ============================================
        // FORM SUBMIT - PERBAIKAN
        // ============================================
        const form = document.getElementById('formPermohonan');
        const btnDraft = document.getElementById('btnDraft');
        const btnSubmit = document.getElementById('btnSubmit');
        
        // Handler untuk tombol Draft
        btnDraft.addEventListener('click', function(e) {
            // Hapus required untuk file upload agar bisa save draft tanpa file
            const fileInputs = form.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.required = false;
            });
            
            // Form akan submit normal
            return true;
        });
        
        // Handler untuk tombol Submit
        btnSubmit.addEventListener('click', function(e) {
            // Cek semua field required
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalid = null;
            
            requiredFields.forEach(field => {
                // Skip file input yang tidak visible
                if (field.type === 'file') {
                    const parentField = field.closest('.mb-3');
                    if (parentField && parentField.classList.contains('d-none')) {
                        return; // Skip hidden file inputs
                    }
                }
                
                if (!field.value || field.value.trim() === '') {
                    isValid = false;
                    field.classList.add('is-invalid');
                    if (!firstInvalid) {
                        firstInvalid = field;
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang bertanda (*) sebelum submit.');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
                return false;
            }
            
            // Konfirmasi submit
            if (!confirm('Apakah Anda yakin ingin mensubmit permohonan ini? Permohonan tidak dapat diubah setelah disubmit.')) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });
        
        // ============================================
        // REMOVE is-invalid on input
        // ============================================
        document.querySelectorAll('.form-control, .form-select').forEach(el => {
            el.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
            el.addEventListener('change', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
</script>
@endsection