@extends('layouts.app')

@section('title', 'Detail Permohonan')

@section('content')
<style>
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge.badge-draft {
        background: #e8e8e8;
        color: #555;
    }
    .status-badge.badge-aktif {
        background: #fff3cd;
        color: #856404;
    }
    .status-badge.badge-selesai {
        background: #d4edda;
        color: #155724;
    }
    .detail-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px 25px;
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
    .file-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #f0f9f4;
        border-radius: 6px;
        color: #1a6e4a;
        text-decoration: none;
        font-size: 13px;
        margin: 3px 5px 3px 0;
        transition: all 0.3s;
    }
    .file-link:hover {
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
    .btn-edit-draft {
        background: #f39c12;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-edit-draft:hover {
        background: #d68910;
        color: white;
        transform: translateY(-2px);
    }
    .btn-submit-draft {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .btn-submit-draft:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(26, 110, 74, 0.4);
        color: white;
    }

    .progress-custom {
        height: 25px;
        border-radius: 8px;
        background: #f0f2f5;
        overflow: hidden;
    }
    .progress-custom .progress-bar {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        font-weight: 600;
        font-size: 13px;
        line-height: 25px;
        transition: width 0.5s ease;
    }
    .alert-draft {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
        border-radius: 8px;
        padding: 15px 20px;
    }
    .stage-check {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        margin: 3px 5px 3px 0;
    }
    .stage-check.done {
        background: #d4edda;
        color: #155724;
    }
    .stage-check.pending {
        background: #f0f2f5;
        color: #7f8c8d;
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-file-earmark-text me-2" style="color: #1a6e4a;"></i>
                    Detail Permohonan
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan: </strong>{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <div>
                <!-- Status Badge -->
                <span class="status-badge badge-{{ $permohonan->status }}">
                    <i class="bi {{ $permohonan->status_icon }}"></i>
                    {{ $permohonan->status_label }}
                </span>
            </div>
        </div>

        <!-- Alert untuk Draft -->
        @if($permohonan->isDraft())
        <div class="alert-draft mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Permohonan ini masih dalam status DRAFT.</strong>
                    <span class="text-muted ms-2">Lengkapi data dan submit untuk diproses admin.</span>
                </div>
            </div>
        </div>
        @endif

        <!-- ============================================ -->
        <!-- DATA PEMOHON -->
        <!-- ============================================ -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-person me-2" style="color: #1a6e4a;"></i>
                Data Pemohon Uji
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
                <span class="label">Perusahaan/Instansi</span>
                <span class="value">{{ $permohonan->perusahaan_instansi ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Alamat Lengkap</span>
                <span class="value">{{ $permohonan->alamat }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Nomor Telepon</span>
                <span class="value">{{ $permohonan->telepon }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Nomor Surat</span>
                <span class="value">{{ $permohonan->nomor_surat_permohonan }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tanggal Surat</span>
                <span class="value">{{ $permohonan->tanggal_surat_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_surat_permohonan)->format('d M Y') : '-' }}</span>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- INFORMASI ALSINTAN -->
        <!-- ============================================ -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-tools me-2" style="color: #1a6e4a;"></i>
                Informasi Alsintan yang akan Diuji
            </div>
            <div class="detail-item">
                <span class="label">Jenis Alsintan</span>
                <span class="value">{{ $permohonan->jenis_alsintan }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Status Alsintan</span>
                <span class="value">{{ $permohonan->status_alsintan }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Status Produksi</span>
                <span class="value">{{ $permohonan->status_produksi }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Merek/Model/Tipe</span>
                <span class="value">{{ $permohonan->merek_model_tipe }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tahun Pembuatan</span>
                <span class="value">{{ $permohonan->tahun_pembuatan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jumlah Unit</span>
                <span class="value">{{ $permohonan->jumlah_unit }} unit</span>
            </div>
            
            <div class="mt-3">
                <h6 class="fw-bold text-dark mb-2">Spesifikasi Motor Penggerak</h6>
                <div class="detail-item">
                    <span class="label">Daya Maksimal</span>
                    <span class="value">{{ $permohonan->daya_maksimal ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Putaran Mesin</span>
                    <span class="value">{{ $permohonan->putaran_mesin ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Bahan Bakar</span>
                    <span class="value">{{ $permohonan->bahan_bakar ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Sistem Pendinginan</span>
                    <span class="value">{{ $permohonan->sistem_pendinginan ?? '-' }}</span>
                </div>
            </div>
            
            <div class="mt-3">
                <h6 class="fw-bold text-dark mb-2">Spesifikasi Unit Alat</h6>
                <div class="detail-item">
                    <span class="label">Dimensi (P x L x T)</span>
                    <span class="value">{{ $permohonan->dimensi ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Berat</span>
                    <span class="value">{{ $permohonan->berat ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kapasitas Kerja</span>
                    <span class="value">{{ $permohonan->kapasitas_kerja ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Perlengkapan</span>
                    <span class="value">{{ $permohonan->perlengkapan ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- FILE PERSYARATAN -->
        <!-- ============================================ -->
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-file-earmark me-2" style="color: #1a6e4a;"></i>
                Persyaratan Permohonan Uji
            </div>
            
            @php
                $files = [
                    ['label' => 'Surat Permohonan', 'field' => 'surat_permohonan'],
                    ['label' => 'KTP Pemohon', 'field' => 'ktp'],
                    ['label' => 'Akte Perusahaan', 'field' => 'akte'],
                    ['label' => 'NPWP', 'field' => 'npwp'],
                    ['label' => 'NIB', 'field' => 'nib'],
                ];
                $hasFiles = false;
            @endphp
            
            @foreach($files as $file)
                @if(!empty($permohonan->{$file['field']}))
                    @php $hasFiles = true; @endphp
                    <a href="{{ asset('storage/' . $permohonan->{$file['field']}) }}" target="_blank" class="file-link">
                        <i class="bi bi-file-earmark-{{ 
                            str_ends_with($permohonan->{$file['field']}, '.pdf') ? 'pdf' : 
                            (str_ends_with($permohonan->{$file['field']}, '.jpg') || str_ends_with($permohonan->{$file['field']}, '.jpeg') || str_ends_with($permohonan->{$file['field']}, '.png') ? 'image' : 'text') 
                        }}"></i>
                        {{ $file['label'] }}
                    </a>
                @endif
            @endforeach
            
            @if(!$hasFiles)
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle"></i> Belum ada file yang diupload.
                </p>
            @endif
        </div>

        <!-- ============================================ -->
        <!-- PROGRESS TAHAPAN -->
        <!-- ============================================ -->
        @if(!$permohonan->isDraft())
        <div class="detail-section">
            <div class="section-title">
                <i class="bi bi-graph-up me-2" style="color: #1a6e4a;"></i>
                Progress Pengujian
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Progress:</strong> {{ $permohonan->progress }}%
                    </p>
                    <div class="progress-custom">
                        <div class="progress-bar" style="width: {{ $permohonan->progress }}%">
                            {{ $permohonan->progress }}%
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tahapan:</strong></p>
                    <div>
                        @php
                            $stages = [
                                'validasi_selesai' => 'Validasi',
                                'pengujian_selesai' => 'Pengujian',
                                'test_report_selesai' => 'Test Report',
                                'kuisioner_selesai' => 'Kuisioner'
                            ];
                        @endphp
                        @foreach($stages as $field => $label)
                            <span class="stage-check {{ $permohonan->$field ? 'done' : 'pending' }}">
                                <i class="bi {{ $permohonan->$field ? 'bi-check-circle-fill' : 'bi-clock' }}"></i>
                                {{ $label }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- ============================================ -->
        <!-- TOMBOL KEMBALI -->
        <!-- ============================================ -->
        <div class="d-flex gap-2 mb-4">
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard.admin') : route('dashboard.pemohon') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
            
            @if($permohonan->isDraft())
                <a href="{{ route('permohonan.edit', $permohonan->id) }}" class="btn-edit-draft">
                    <i class="bi bi-pencil"></i> Edit Draft
                </a>
                <form action="{{ route('permohonan.submit', $permohonan->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-submit-draft" onclick="return confirm('Yakin ingin mensubmit permohonan ini?')">
                        <i class="bi bi-send"></i> Submit
                    </button>
                </form>
                <form action="{{ route('permohonan.destroy', $permohonan->id) }}" method="POST" 
                    style="display: inline-block;"
                    onsubmit="return confirm('Yakin ingin menghapus draft ini? Semua data akan hilang permanen.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: 10px 25px; border-radius: 8px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; border: none;">
                        <i class="bi bi-trash"></i> Hapus Draft
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection