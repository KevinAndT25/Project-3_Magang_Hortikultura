@extends('layouts.app')

@section('title', 'Detail Kuisioner')

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
        width: 250px;
        flex-shrink: 0;
        font-size: 14px;
    }
    
    .detail-item .value {
        color: #2c3e50;
        font-size: 14px;
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
                    <i class="bi bi-clipboard2-data me-2" style="color: #27ae60;"></i>
                    Detail Kuisioner
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <span class="badge-status badge-success">
                <i class="bi bi-check-circle"></i> Selesai
            </span>
        </div>

        @if($kuisioner)
            <!-- Profil Responden -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-person me-2" style="color: #1a6e4a;"></i>
                    I. Profil Responden
                </div>
                <div class="detail-item">
                    <span class="label">Nama Responden</span>
                    <span class="value">{{ $kuisioner->nama_responden }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">No. Telepon Responden</span>
                    <span class="value">{{ $kuisioner->telepon_responden }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Usia</span>
                    <span class="value">{{ $kuisioner->usia }} tahun</span>
                </div>
                <div class="detail-item">
                    <span class="label">Jenis Kelamin</span>
                    <span class="value">{{ $kuisioner->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Pendidikan Terakhir</span>
                    <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->pendidikan_terakhir)) }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Nama Perusahaan/Instansi</span>
                    <span class="value">{{ $kuisioner->nama_perusahaan_instansi }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Alamat Perusahaan/Instansi</span>
                    <span class="value">{{ $kuisioner->alamat_perusahaan }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Jabatan di Perusahaan</span>
                    <span class="value">{{ $kuisioner->jabatan == 'pemilik_owner' ? 'Pemilik/Owner' : 'Staff' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Lama Bekerja</span>
                    <span class="value">{{ $kuisioner->lama_bekerja_tahun }} tahun</span>
                </div>
            </div>

            <!-- Informasi Umum -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-info-circle me-2" style="color: #1a6e4a;"></i>
                    II. Informasi Umum Perihal Pengurusan Pengujian
                </div>
                <div class="detail-item">
                    <span class="label">Pengujian Pertama?</span>
                    <span class="value">{{ $kuisioner->pengujian_pertama ? 'Ya' : 'Tidak' }}</span>
                </div>
                @if(!$kuisioner->pengujian_pertama)
                <div class="detail-item">
                    <span class="label">Pengujian ke-</span>
                    <span class="value">{{ $kuisioner->pengujian_ke }}</span>
                </div>
                @endif
                <div class="detail-item">
                    <span class="label">Mewakili</span>
                    <span class="value">{{ $kuisioner->mewakili == 'diri_sendiri' ? 'Diri Sendiri' : 'Perusahaan' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Terakhir Mengajukan</span>
                    <span class="value">{{ $kuisioner->terakhir_mengajukan ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Unit Layanan</span>
                    <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->unit_layanan)) }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Hari Laporan Keluar</span>
                    <span class="value">{{ $kuisioner->hari_laporan_keluar }} hari</span>
                </div>
            </div>

            <!-- Penilaian Servqual -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-table me-2" style="color: #1a6e4a;"></i>
                    III. Penilaian Servqual
                </div>
                <div class="detail-item">
                    <span class="label">1. Pelayanan kepada konsumen</span>
                    <span class="value">{{ $kuisioner->servqual_1 }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">2. Keramahan personil</span>
                    <span class="value">{{ $kuisioner->servqual_2 }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">3. Ketepatan waktu pengujian</span>
                    <span class="value">{{ $kuisioner->servqual_3 }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">4. Kelengkapan alat</span>
                    <span class="value">{{ $kuisioner->servqual_4 }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">5. Ketepatan waktu penyerahan laporan uji</span>
                    <span class="value">{{ $kuisioner->servqual_5 }}</span>
                </div>
                @if($kuisioner->kesan_pesan)
                <div class="detail-item">
                    <span class="label">Kesan Pesan</span>
                    <span class="value">{{ $kuisioner->kesan_pesan }}</span>
                </div>
                @endif
            </div>

            <!-- Kepuasan Umum -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="bi bi-star me-2" style="color: #1a6e4a;"></i>
                    IV. Kepuasan Secara Umum
                </div>
                <div class="detail-item">
                    <span class="label">Tingkat Kepuasan</span>
                    <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->kepuasan_umum)) }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Rekomendasi</span>
                    <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->rekomendasi)) }}</span>
                </div>
                @if($kuisioner->ide_saran)
                <div class="detail-item">
                    <span class="label">Ide & Saran</span>
                    <span class="value">{{ $kuisioner->ide_saran }}</span>
                </div>
                @endif
            </div>
        @else
            <div class="detail-section">
                <div class="text-center py-4" style="color: #95a5a6;">
                    <i class="bi bi-clipboard2-data" style="font-size: 48px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                    <p>Kuisioner belum diisi.</p>
                </div>
            </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard.admin') : route('dashboard.pemohon') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
            @if(auth()->user()->isPemohon() && !$kuisioner)
                <a href="{{ route('kuisioner.create', $permohonan->id) }}" class="btn-back" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-pencil"></i> Isi Kuisioner
                </a>
            @endif  
            @if($kuisioner && $kuisioner->is_submit)
            <a href="{{ route('kuisioner.pdf', $permohonan->id) }}" target="_blank" 
            class="btn btn-danger btn-sm" 
            style="padding: 8px 16px; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: none; background: #e74c3c; color: white; text-decoration: none;">
                <i class="bi bi-file-pdf"></i> Download PDF
            </a>
            @endif
        </div>
    </div>
</div>
@endsection