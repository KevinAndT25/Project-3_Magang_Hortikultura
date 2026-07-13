@extends('layouts.app')

@section('title', 'Kuisioner Kepuasan')

@section('content')
<style>
    .detail-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px 30px;
        margin-bottom: 20px;
    }
    .detail-section .section-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f2f5;
    }
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
    
    /* Radio & Checkbox Styling */
    .radio-group {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        padding-top: 5px;
    }
    
    .radio-group .radio-option {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        font-size: 14px;
        color: #2c3e50;
    }
    
    .radio-group .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #1a6e4a;
        cursor: pointer;
    }
    
    /* Servqual Table */
    .servqual-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .servqual-table thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        padding: 10px 12px;
        border-bottom: 2px solid #e0e5ec;
        text-align: center;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .servqual-table thead th:first-child {
        text-align: left;
    }
    
    .servqual-table tbody td {
        padding: 10px 12px;
        border-bottom: 1px solid #f0f2f5;
        vertical-align: middle;
    }
    
    .servqual-table tbody td:first-child {
        font-weight: 500;
        color: #2c3e50;
    }
    
    .servqual-table tbody td:not(:first-child) {
        text-align: center;
    }
    
    .servqual-table .radio-inline {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .servqual-table .radio-inline input[type="radio"] {
        width: 16px;
        height: 16px;
        accent-color: #1a6e4a;
        cursor: pointer;
        margin: 0;
    }
    
    .servqual-table .radio-inline label {
        font-size: 13px;
        color: #2c3e50;
        cursor: pointer;
        margin: 0;
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
    
    .alert-warning-custom {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 20px;
    }
    
    .alert-warning-custom i {
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
    
    .btn-submit-kuisioner {
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
    
    .btn-submit-kuisioner:hover {
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
        
        .servqual-table {
            font-size: 12px;
        }
        
        .servqual-table thead th,
        .servqual-table tbody td {
            padding: 6px 8px;
        }
        
        .servqual-table .radio-inline input[type="radio"] {
            width: 14px;
            height: 14px;
        }
        
        .radio-group {
            gap: 12px;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-clipboard2-data me-2" style="color: #1a6e4a;"></i>
                    Kuisioner Kepuasan Pengguna
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        <!-- Info Permohonan -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-file-earmark-text me-2" style="color: #1a6e4a;"></i>
                Informasi Permohonan
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
        </div>

        <!-- Form Kuisioner -->
        <form method="POST" action="{{ route('kuisioner.store', $permohonan->id) }}" id="formKuisioner">
            @csrf

            <!-- ============================================ -->
            <!-- I. PROFIL RESPONDEN -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">I</span>
                    Profil Responden
                </div>
                <div class="section-subtitle">
                    Isi data diri responden pengguna layanan
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_responden" class="form-label">
                            Nama Responden <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('nama_responden') is-invalid @enderror" 
                               id="nama_responden" name="nama_responden" 
                               placeholder="Nama lengkap responden"
                               value="{{ old('nama_responden') }}" required>
                        @error('nama_responden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telepon_responden" class="form-label">
                            No. Telepon Responden <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('telepon_responden') is-invalid @enderror" 
                               id="telepon_responden" name="telepon_responden" 
                               placeholder="08xxxxxxxxx"
                               value="{{ old('telepon_responden') }}" required>
                        @error('telepon_responden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="usia" class="form-label">
                            Usia <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control @error('usia') is-invalid @enderror" 
                               id="usia" name="usia" 
                               placeholder="35"
                               min="1" value="{{ old('usia') }}" required>
                        <div class="form-text">tahun</div>
                        @error('usia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Jenis Kelamin <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="jenis_kelamin" value="L" 
                                       {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                                Laki-laki
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="jenis_kelamin" value="P" 
                                       {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                                Perempuan
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="pendidikan_terakhir" class="form-label">
                            Pendidikan Terakhir <span class="required">*</span>
                        </label>
                        <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror" 
                                id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                            <option value="">-- Pilih --</option>
                            <option value="tidak_sekolah" {{ old('pendidikan_terakhir') == 'tidak_sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                            <option value="sd" {{ old('pendidikan_terakhir') == 'sd' ? 'selected' : '' }}>SD/Sederajat</option>
                            <option value="smp" {{ old('pendidikan_terakhir') == 'smp' ? 'selected' : '' }}>SMP/Sederajat</option>
                            <option value="sma" {{ old('pendidikan_terakhir') == 'sma' ? 'selected' : '' }}>SMA/Sederajat</option>
                            <option value="akademi" {{ old('pendidikan_terakhir') == 'akademi' ? 'selected' : '' }}>Akademi/Diploma</option>
                            <option value="sarjana" {{ old('pendidikan_terakhir') == 'sarjana' ? 'selected' : '' }}>Sarjana/S1</option>
                            <option value="pascasarjana" {{ old('pendidikan_terakhir') == 'pascasarjana' ? 'selected' : '' }}>Pascasarjana/S2</option>
                            <option value="doktoral" {{ old('pendidikan_terakhir') == 'doktoral' ? 'selected' : '' }}>Doktoral/S3</option>
                        </select>
                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_perusahaan_instansi" class="form-label">
                            Nama Perusahaan/Instansi <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('nama_perusahaan_instansi') is-invalid @enderror" 
                               id="nama_perusahaan_instansi" name="nama_perusahaan_instansi" 
                               placeholder="Nama perusahaan atau instansi"
                               value="{{ old('nama_perusahaan_instansi') }}" required>
                        @error('nama_perusahaan_instansi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="alamat_perusahaan" class="form-label">
                            Alamat Perusahaan/Instansi <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('alamat_perusahaan') is-invalid @enderror" 
                               id="alamat_perusahaan" name="alamat_perusahaan" 
                               placeholder="Alamat lengkap"
                               value="{{ old('alamat_perusahaan') }}" required>
                        @error('alamat_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="jabatan" class="form-label">
                            Jabatan di Perusahaan <span class="required">*</span>
                        </label>
                        <select class="form-select @error('jabatan') is-invalid @enderror" 
                                id="jabatan" name="jabatan" required>
                            <option value="">-- Pilih --</option>
                            <option value="pemilik_owner" {{ old('jabatan') == 'pemilik_owner' ? 'selected' : '' }}>Pemilik/Owner</option>
                            <option value="staff" {{ old('jabatan') == 'staff' ? 'selected' : '' }}>Staff (termasuk direktur, manager, operasional)</option>
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="lama_bekerja_tahun" class="form-label">
                            Lama Bekerja <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control @error('lama_bekerja_tahun') is-invalid @enderror" 
                               id="lama_bekerja_tahun" name="lama_bekerja_tahun" 
                               placeholder="0"
                               min="0" value="{{ old('lama_bekerja_tahun', '0') }}" required>
                        <div class="form-text">tahun</div>
                        @error('lama_bekerja_tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- II. INFORMASI UMUM -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">II</span>
                    Informasi Umum Perihal Pengurusan Pengujian
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">
                            Apakah ini pengujian yang pertama? <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="pengujian_pertama" value="1" 
                                       {{ old('pengujian_pertama') == '1' ? 'checked' : '' }} 
                                       onchange="togglePengujianKe()" required>
                                Ya
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="pengujian_pertama" value="0" 
                                       {{ old('pengujian_pertama') == '0' ? 'checked' : '' }} 
                                       onchange="togglePengujianKe()" required>
                                Tidak
                            </label>
                        </div>
                        @error('pengujian_pertama')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12" id="pengujian_ke_container" style="display: {{ old('pengujian_pertama') == '0' ? 'block' : 'none' }};">
                        <label for="pengujian_ke" class="form-label">
                            Ini pengujian yang ke-... <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control @error('pengujian_ke') is-invalid @enderror" 
                               id="pengujian_ke" name="pengujian_ke" 
                               placeholder="2"
                               min="2" value="{{ old('pengujian_ke') }}">
                        @error('pengujian_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Dalam proses mengurus izin, Anda mewakili <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="mewakili" value="diri_sendiri" 
                                       {{ old('mewakili') == 'diri_sendiri' ? 'checked' : '' }} required>
                                Diri Sendiri
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="mewakili" value="perusahaan" 
                                       {{ old('mewakili') == 'perusahaan' ? 'checked' : '' }} required>
                                Perusahaan
                            </label>
                        </div>
                        @error('mewakili')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="terakhir_mengajukan" class="form-label">
                            Kapan terakhir Anda mengajukan permohonan pengujian di LPMA UPTD BMSPP?
                        </label>
                        <input type="text" class="form-control @error('terakhir_mengajukan') is-invalid @enderror" 
                               id="terakhir_mengajukan" name="terakhir_mengajukan" 
                               placeholder="dd---yyyy"
                               value="{{ old('terakhir_mengajukan') }}">
                        @error('terakhir_mengajukan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="unit_layanan" class="form-label">
                            Unit Layanan yang Dituju <span class="required">*</span>
                        </label>
                        <select class="form-select @error('unit_layanan') is-invalid @enderror" 
                                id="unit_layanan" name="unit_layanan" required>
                            <option value="">-- Pilih --</option>
                            <option value="uji_awal" {{ old('unit_layanan') == 'uji_awal' ? 'selected' : '' }}>Uji Awal</option>
                            <option value="uji_ulang" {{ old('unit_layanan') == 'uji_ulang' ? 'selected' : '' }}>Uji Ulang</option>
                            <option value="uji_perpanjangan" {{ old('unit_layanan') == 'uji_perpanjangan' ? 'selected' : '' }}>Uji Perjanjian</option>
                        </select>
                        @error('unit_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="hari_laporan_keluar" class="form-label">
                            Menurut perkiraan, berapa hari laporan hasil uji keluar setelah pengujian selesai? <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control @error('hari_laporan_keluar') is-invalid @enderror" 
                               id="hari_laporan_keluar" name="hari_laporan_keluar" 
                               placeholder="0"
                               min="0" value="{{ old('hari_laporan_keluar', '0') }}" required>
                        <div class="form-text">hari</div>
                        @error('hari_laporan_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- III. PERTANYAAN SERVQUAL -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">III</span>
                    Pertanyaan Servqual / Pengamatan Pelayanan Pengujian Alsintan
                </div>
                <div class="section-subtitle">
                    Beri tanda √ dengan nilai 1–5 untuk setiap kriteria
                </div>

                <div class="table-responsive">
                    <table class="servqual-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 35%;">Pertanyaan</th>
                                <th style="width: 12%;">1</th>
                                <th style="width: 12%;">2</th>
                                <th style="width: 12%;">3</th>
                                <th style="width: 12%;">4</th>
                                <th style="width: 12%;">5</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $servqualQuestions = [
                                    ['id' => 'servqual_1', 'label' => 'Pelayanan kepada konsumen'],
                                    ['id' => 'servqual_2', 'label' => 'Keramahan personil'],
                                    ['id' => 'servqual_3', 'label' => 'Ketepatan waktu pengujian'],
                                    ['id' => 'servqual_4', 'label' => 'Kelengkapan alat'],
                                    ['id' => 'servqual_5', 'label' => 'Ketepatan waktu penyerahan laporan uji'],
                                ];
                            @endphp
                            @foreach($servqualQuestions as $index => $q)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $q['label'] }}</td>
                                @for($i = 1; $i <= 5; $i++)
                                <td>
                                    <div class="radio-inline">
                                        <input type="radio" name="{{ $q['id'] }}" value="{{ $i }}" 
                                               {{ old($q['id']) == $i ? 'checked' : '' }}
                                               {{ $index == 0 && $i == 3 ? 'checked' : '' }}
                                               required>
                                    </div>
                                </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @error('servqual_1')
                    <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                @enderror
                @error('servqual_2')
                    <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                @enderror
                @error('servqual_3')
                    <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                @enderror
                @error('servqual_4')
                    <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                @enderror
                @error('servqual_5')
                    <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                @enderror

                <!-- Legend Servqual -->
                <div class="mt-3" style="display: flex; gap: 15px; flex-wrap: wrap; font-size: 12px; color: #7f8c8d; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                    <span><strong>Keterangan:</strong></span>
                    <span>1 = Sangat Tidak Puas</span>
                    <span>2 = Tidak Puas</span>
                    <span>3 = Netral/Biasa Saja</span>
                    <span>4 = Puas</span>
                    <span>5 = Sangat Puas</span>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- IV. KEPUASAN UMUM -->
            <!-- ============================================ -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">IV</span>
                    Kepuasan Secara Umum
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="kepuasan_umum" class="form-label">
                            Setelah mengikuti seluruh proses pelayanan pengujian alsintan di LPMA UPTD BMSPP, menurut Anda kepuasan yang Anda rasakan seperti apa? <span class="required">*</span>
                        </label>
                        <select class="form-select @error('kepuasan_umum') is-invalid @enderror" 
                                id="kepuasan_umum" name="kepuasan_umum" required>
                            <option value="">-- Pilih --</option>
                            <option value="sangat_tidak_puas" {{ old('kepuasan_umum') == 'sangat_tidak_puas' ? 'selected' : '' }}>Sangat Tidak Puas</option>
                            <option value="tidak_puas" {{ old('kepuasan_umum') == 'tidak_puas' ? 'selected' : '' }}>Tidak Puas</option>
                            <option value="netral" {{ old('kepuasan_umum') == 'netral' ? 'selected' : '' }}>Netral/Biasa Saja</option>
                            <option value="puas" {{ old('kepuasan_umum') == 'puas' ? 'selected' : '' }}>Puas</option>
                            <option value="sangat_puas" {{ old('kepuasan_umum') == 'sangat_puas' ? 'selected' : '' }}>Sangat Puas</option>
                        </select>
                        @error('kepuasan_umum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="rekomendasi" class="form-label">
                            Apakah Anda bersedia merekomendasikan atau mempromosikan layanan pengujian di LPMA UPTD BMSPP? <span class="required">*</span>
                        </label>
                        <select class="form-select @error('rekomendasi') is-invalid @enderror" 
                                id="rekomendasi" name="rekomendasi" required>
                            <option value="">-- Pilih --</option>
                            <option value="sangat_tidak" {{ old('rekomendasi') == 'sangat_tidak' ? 'selected' : '' }}>Sangat Tidak Bersedia Merekomendasikan</option>
                            <option value="tidak" {{ old('rekomendasi') == 'tidak' ? 'selected' : '' }}>Tidak Bersedia Merekomendasikan</option>
                            <option value="terserah" {{ old('rekomendasi') == 'terserah' ? 'selected' : '' }}>Terserah yang Bersangkutan</option>
                            <option value="merekomendasikan" {{ old('rekomendasi') == 'merekomendasikan' ? 'selected' : '' }}>Merekomendasikan</option>
                            <option value="sangat_merekomendasikan" {{ old('rekomendasi') == 'sangat_merekomendasikan' ? 'selected' : '' }}>Sangat Merekomendasikan</option>
                        </select>
                        @error('rekomendasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="ide_saran" class="form-label">
                            Ide dan Saran untuk Pihak Pelayanan Pengujian LPMA UPTD BMSPP
                        </label>
                        <textarea class="form-control @error('ide_saran') is-invalid @enderror" 
                                  id="ide_saran" name="ide_saran" rows="4"
                                  placeholder="Tuliskan ide dan saran Anda untuk peningkatan pelayanan...">{{ old('ide_saran') }}</textarea>
                        @error('ide_saran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="alert-warning-custom" style="margin-bottom: 20px">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong>Perhatian:</strong>
                Lengkapi semua kolom wajib (*) dan semua penilaian Servqual untuk mengirim kuisioner.
            </div>

            <!-- Action Buttons -->
            <div class="form-section">
                <div class="form-actions" style="margin-top: -25px;">
                    <a href="{{ route('dashboard.pemohon') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit" class="btn-submit-kuisioner" id="btnSubmit">
                        <i class="bi bi-send"></i> Kirim Kuisioner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // TOGGLE PENGUJIAN KE
        // ============================================
        window.togglePengujianKe = function() {
            const pengujianPertama = document.querySelector('input[name="pengujian_pertama"]:checked');
            const container = document.getElementById('pengujian_ke_container');
            const input = document.getElementById('pengujian_ke');
            
            if (pengujianPertama && pengujianPertama.value === '0') {
                container.style.display = 'block';
                input.required = true;
            } else {
                container.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        };

        // ============================================
        // FORM SUBMIT VALIDATION
        // ============================================
        const form = document.getElementById('formKuisioner');
        
        form.addEventListener('submit', function(e) {
            // Cek semua radio button servqual
            const servqualIds = ['servqual_1', 'servqual_2', 'servqual_3', 'servqual_4', 'servqual_5'];
            let allChecked = true;
            
            servqualIds.forEach(id => {
                const checked = document.querySelector(`input[name="${id}"]:checked`);
                if (!checked) {
                    allChecked = false;
                }
            });
            
            if (!allChecked) {
                e.preventDefault();
                alert('Silakan lengkapi semua penilaian Servqual (1-5) untuk setiap kriteria.');
                return false;
            }
            
            // Konfirmasi submit
            if (!confirm('Apakah Anda yakin ingin mengirim kuisioner ini? Data tidak dapat diedit kembali.')) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });

        // ============================================
        // INITIAL TOGGLE
        // ============================================
        togglePengujianKe();
    });
</script>
@endsection