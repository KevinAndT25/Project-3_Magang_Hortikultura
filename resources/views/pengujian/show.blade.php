@extends('layouts.app')

@section('title', 'Detail Pengujian')

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
    
    .detail-item {
        display: flex;
        padding: 8px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .detail-item .label {
        font-weight: 600;
        color: #7f8c8d;
        width: 200px;
        flex-shrink: 0;
        font-size: 14px;
    }
    
    .detail-item .value {
        color: #2c3e50;
        font-size: 14px;
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
    
    .file-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 18px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 3px solid #1a6e4a;
        transition: all 0.3s;
    }
    
    .file-card:hover {
        background: #f0f2f5;
    }
    
    .file-card .file-icon {
        font-size: 28px;
        color: #1a6e4a;
    }
    
    .file-card .file-info {
        flex: 1;
    }
    
    .file-card .file-name {
        font-weight: 500;
        color: #2c3e50;
        font-size: 14px;
    }
    
    .file-card .file-size {
        font-size: 12px;
        color: #95a5a6;
    }
    
    .file-card .file-actions {
        display: flex;
        gap: 8px;
    }
    
    .file-card .btn-view {
        background: #e3f2fd;
        color: #1565c0;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .file-card .btn-view:hover {
        background: #1565c0;
        color: white;
    }
    
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-status.badge-success {
        background: #d4edda;
        color: #155724;
    }
    .badge-status.badge-warning {
        background: #fff3cd;
        color: #856404;
    }
    .badge-status.badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }
    .badge-status.badge-danger {
        background: #fce4ec;
        color: #c62828;
    }
    
    .btn-back {
        background: #f0f2f5;
        color: #7f8c8d;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #e0e5ec;
        color: #2c3e50;
    }
    
    .alert-warning-custom {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 15px;
    }
    
    .alert-warning-custom i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    .alert-success-custom {
        background: #d4edda;
        border: 1px solid #27ae60;
        color: #155724;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 15px;
    }
    
    .alert-success-custom i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    .alert-danger-custom {
        background: #fce4ec;
        border: 1px solid #e74c3c;
        color: #c62828;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 15px;
    }
    
    .alert-danger-custom i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    /* Tombol Persetujuan */
    .btn-approve {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(39,174,96,0.4);
        color: white;
    }
    
    .btn-reject {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(231,76,60,0.4);
        color: white;
    }
    
    .btn-approve:disabled, .btn-reject:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-clipboard2-check me-2" style="color: #27ae60;"></i>
                    Detail Pengujian
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <span class="badge-status badge-success">
                <i class="bi bi-check-circle"></i> Selesai
            </span>
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

        <!-- Detail Pengujian -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-clipboard-data me-2" style="color: #1a6e4a;"></i>
                Data Pengujian
            </div>
            
            <div class="detail-item">
                <span class="label">Nomor Permohonan Uji</span>
                <span class="value">{{ $permohonan->nomor_surat_permohonan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tanggal Pengujian</span>
                <span class="value">{{ $pengujian->tanggal_pengujian ? \Carbon\Carbon::parse($pengujian->tanggal_pengujian)->format('d M Y') : '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Lokasi Pengujian</span>
                <span class="value">{{ $pengujian->lokasi ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Deskripsi Pengujian</span>
                <span class="value">{{ $pengujian->deskripsi ?? '-' }}</span>
            </div>
        </div>

        <!-- Status Persetujuan (khusus pemohon) -->
        @if(auth()->user()->isPemohon())
            @php
                $isApproved = $permohonan->pengujian_disetujui ?? false;
                $isRejected = $permohonan->pengujian_ditolak ?? false;
                $canApprove = !$isApproved && !$isRejected;
            @endphp
            
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-check2-circle me-2" style="color: #1a6e4a;"></i>
                    Persetujuan Pengujian
                </div>
                
                @if($isApproved)
                    <div class="alert-success-custom">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>Pengujian telah disetujui.</strong> Permohonan akan melanjutkan ke tahap selanjutnya (Test Report).
                    </div>
                @elseif($isRejected)
                    <div class="alert-danger-custom">
                        <i class="bi bi-x-circle-fill"></i>
                        <strong>Pengujian tidak disetujui.</strong> Proses permohonan berakhir di tahap pengujian.
                    </div>
                @else
                    <div class="alert-warning-custom">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Persetujuan diperlukan:</strong>
                        Silakan setujui atau tolak hasil pengujian untuk melanjutkan proses.
                    </div>
                    
                    <div class="d-flex gap-3 flex-wrap mt-3">
                        <form action="{{ route('pengujian.approve', $permohonan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-approve" onclick="return confirm('Apakah Anda menyetujui hasil pengujian ini dan ingin melanjutkan ke tahap Test Report?')">
                                <i class="bi bi-check-circle"></i> Setujui & Lanjutkan
                            </button>
                        </form>
                        
                        <form action="{{ route('pengujian.reject', $permohonan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-reject" onclick="return confirm('Apakah Anda tidak menyetujui hasil pengujian ini? Permohonan akan berhenti di tahap ini dan status menjadi Selesai.')">
                                <i class="bi bi-x-circle"></i> Tidak Setuju & Akhiri
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @else
            <!-- Untuk Admin: Tampilkan status persetujuan -->
            @php
                $isApproved = $permohonan->pengujian_disetujui ?? false;
                $isRejected = $permohonan->pengujian_ditolak ?? false;
            @endphp
            
            @if($isApproved)
                <div class="detail-section">
                    <div class="section-title">
                        <i class="bi bi-check2-circle me-2" style="color: #1a6e4a;"></i>
                        Status Persetujuan Pemohon
                    </div>
                    <div class="alert-success-custom">
                        <i class="bi bi-check-circle-fill"></i>
                        <strong>Pemohon telah menyetujui pengujian.</strong> Permohonan siap melanjutkan ke tahap Test Report.
                    </div>
                </div>
            @elseif($isRejected)
                <div class="detail-section">
                    <div class="section-title">
                        <i class="bi bi-check2-circle me-2" style="color: #1a6e4a;"></i>
                        Status Persetujuan Pemohon
                    </div>
                    <div class="alert-danger-custom">
                        <i class="bi bi-x-circle-fill"></i>
                        <strong>Pemohon tidak menyetujui pengujian.</strong> Proses permohonan berakhir di tahap pengujian.
                    </div>
                </div>
            @else
                <div class="detail-section">
                    <div class="section-title">
                        <i class="bi bi-check2-circle me-2" style="color: #1a6e4a;"></i>
                        Status Persetujuan Pemohon
                    </div>
                    <div class="alert-warning-custom">
                        <i class="bi bi-clock-history"></i>
                        <strong>Menunggu persetujuan pemohon.</strong>
                        Pemohon belum memberikan persetujuan untuk hasil pengujian.
                    </div>
                </div>
            @endif
        @endif

        <!-- File Dokumentasi Pengujian -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-files me-2" style="color: #1a6e4a;"></i>
                File Dokumentasi Pengujian
            </div>
            
            @if($pengujian && $pengujian->file_pengujian_multiple && count($pengujian->file_pengujian_multiple) > 0)
                @foreach($pengujian->file_pengujian_multiple as $file)
                    @php
                        $fileExists = Storage::disk('public')->exists($file);
                        $fileSize = $fileExists ? Storage::disk('public')->size($file) : 0;
                        $sizeMB = $fileSize > 0 ? number_format($fileSize / 1024 / 1024, 2) : '0';
                        $fileUrl = route('file.show', ['path' => $file]);
                        $fileName = basename($file);
                        
                        // Tentukan icon berdasarkan ekstensi
                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $iconClass = 'bi-file-earmark';
                        if (in_array($extension, ['pdf'])) {
                            $iconClass = 'bi-file-earmark-pdf';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'])) {
                            $iconClass = 'bi-file-earmark-image';
                        } elseif (in_array($extension, ['doc', 'docx'])) {
                            $iconClass = 'bi-file-earmark-word';
                        } elseif (in_array($extension, ['xls', 'xlsx'])) {
                            $iconClass = 'bi-file-earmark-excel';
                        } elseif (in_array($extension, ['zip', 'rar', '7z'])) {
                            $iconClass = 'bi-file-earmark-zip';
                        }
                    @endphp
                    
                    <div class="file-card">
                        <div class="file-icon">
                            <i class="bi {{ $iconClass }}"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">{{ $fileName }}</div>
                            <div class="file-size">
                                @if($fileExists)
                                    {{ $sizeMB }} MB
                                @else
                                    <span style="color: #e74c3c;">File tidak ditemukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="file-actions">
                            @if($fileExists)
                                <!-- Tombol Lihat -->
                                <a href="{{ $fileUrl }}" target="_blank" class="btn-view">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            @else
                                <span style="font-size: 12px; color: #e74c3c;">
                                    <i class="bi bi-exclamation-triangle"></i> File tidak tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4" style="color: #95a5a6;">
                    <i class="bi bi-file-earmark" style="font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                    <p>Belum ada file dokumentasi yang diunggah.</p>
                </div>
            @endif
        </div>

        <!-- Tombol Kembali -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard.admin') : route('dashboard.pemohon') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection