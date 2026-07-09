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
                <span class="value">{{ $pengujian->nomor_permohonan_uji ?? '-' }}</span>
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

        <!-- Tombol Kembali -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('dashboard.admin') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection