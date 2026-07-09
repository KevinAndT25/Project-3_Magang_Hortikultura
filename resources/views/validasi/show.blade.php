@extends('layouts.app')

@section('title', 'Detail Validasi')

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
        width: 180px;
        flex-shrink: 0;
        font-size: 14px;
    }
    
    .detail-item .value {
        color: #2c3e50;
        font-size: 14px;
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
    
    .file-card .btn-download {
        background: #e8f5e9;
        color: #1a6e4a;
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
    }
    
    .file-card .btn-download:hover {
        background: #1a6e4a;
        color: white;
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
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-check2-circle me-2" style="color: #27ae60;"></i>
                    Detail Validasi
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan: </strong>{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <span class="badge-status badge-success">
                <i class="bi bi-check-circle"></i> Selesai
            </span>
        </div>

        <!-- Detail Permohonan -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-file-earmark-text me-2" style="color: #1a6e4a;"></i>
                Informasi Permohonan
            </div>
            <div class="detail-item">
                <span class="label">Nomor Permohonan</span>
                <span class="value">{{ $permohonan->no_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Nama Pemohon</span>
                <span class="value">{{ $permohonan->nama_pemohon }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Status Pemohon</span>
                <span class="value">{{ $permohonan->status_pemohon }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jenis Alsintan</span>
                <span class="value">{{ $permohonan->jenis_alsintan }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Merek/Model/Tipe</span>
                <span class="value">{{ $permohonan->merek_model_tipe }}</span>
            </div>
        </div>

        <!-- File Validasi -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-files me-2" style="color: #1a6e4a;"></i>
                File Kaji Ulang & Kontrak
            </div>
            
            @if($validasi && $validasi->file_kaji_ulang_multiple && count($validasi->file_kaji_ulang_multiple) > 0)
                @foreach($validasi->file_kaji_ulang_multiple as $file)
                    <div class="file-card">
                        <div class="file-icon">
                            <i class="bi {{ 
                                str_ends_with($file, '.pdf') ? 'bi-file-earmark-pdf' : 
                                (str_ends_with($file, '.jpg') || str_ends_with($file, '.jpeg') || str_ends_with($file, '.png') ? 'bi-file-earmark-image' : 'bi-file-earmark') 
                            }}"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">{{ basename($file) }}</div>
                            <div class="file-size">
                                @php
                                    $size = Storage::disk('public')->exists($file) ? Storage::disk('public')->size($file) : 0;
                                    $sizeMB = $size > 0 ? number_format($size / 1024 / 1024, 2) : '0';
                                @endphp
                                {{ $sizeMB }} MB
                            </div>
                        </div>
                        <div class="file-actions">
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn-download">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4" style="color: #95a5a6;">
                    <i class="bi bi-file-earmark" style="font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                    <p>Belum ada file yang diunggah.</p>
                </div>
            @endif
        </div>

        <!-- Tombol Kembali -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('dashboard.' . auth()->user()->role) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection     