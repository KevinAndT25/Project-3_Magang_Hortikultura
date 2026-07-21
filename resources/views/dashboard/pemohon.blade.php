@extends('layouts.app')

@section('title', 'Dashboard Pemohon')

@section('content')
<style>
    /* Header Dashboard */
    .dashboard-header {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .dashboard-header h4 {
        font-weight: 700;
        margin-bottom: 3px;
        position: relative;
        z-index: 1;
    }
    .dashboard-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }
    
    /* Widget Cards */
    .widget-card {
        border-radius: 12px;
        padding: 20px 25px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        border: none;
        height: 100%;
    }
    .widget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .widget-card .widget-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 35px;
        opacity: 0.15;
    }
    .widget-card h6 {
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 5px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .widget-card h2 {
        font-weight: 700;
        margin-bottom: 0;
        font-size: 32px;
    }
    .widget-draft {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    }
    .widget-aktif {
        background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
    }
    .widget-selesai {
        background: linear-gradient(135deg, #1a8a4a 0%, #2ecc71 100%);
    }
    
    /* Button Permohonan Baru */
    .btn-permohonan-baru {
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
        font-size: 14px;
        text-decoration: none;
    }
    .btn-permohonan-baru:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(26,110,74,0.4);
        color: white;
    }
    
    /* Section Title */
    .section-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 16px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 3px solid #1a6e4a;
        display: inline-block;
    }
    
    /* Table Styling */
    .table-dashboard {
        font-size: 13px;
    }
    .table-dashboard thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #e0e5ec;
        padding: 10px 12px;
        font-size: 12px;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .table-dashboard tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }
    .table-dashboard tbody tr {
        cursor: pointer;
        transition: background 0.2s;
    }
    .table-dashboard tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Badge Status */
    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-status.badge-waiting {
        background: #f0f2f5;
        color: #7f8c8d;
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
    .badge-status.badge-draft {
        background: #e8e8e8;
        color: #555;
        border: 1px dashed #999;
    }
    
    /* Status Dot */
    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 4px;
    }
    .status-dot.dot-success { background: #27ae60; }
    .status-dot.dot-warning { background: #f39c12; }
    .status-dot.dot-secondary { background: #95a5a6; }
    .status-dot.dot-info { background: #3498db; }
    .status-dot.dot-draft { background: #999; }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 30px 20px;
        color: #95a5a6;
    }
    .empty-state i {
        font-size: 36px;
        margin-bottom: 10px;
        opacity: 0.3;
    }
    .empty-state p {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 3px 10px;
        font-size: 11px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: none;
        cursor: pointer;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
    
    /* Clickable row */
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background: #f0f2f5 !important;
    }
    
    .blink-dot {
        animation: blink 1s infinite;
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 6px;
    }
    .blink-dot.dot-warning {
        background: #f39c12;
    }
    .btn-action.btn-warning-action {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
    }
    .btn-action.btn-warning-action:hover {
        background: #ffe69c;
    }
    
    /* Card Table */
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .card-table .card-body {
        padding: 0;
        overflow-x: auto;
    }
    .card-table .card-header {
        background: white;
        border-bottom: 1px solid #f0f2f5;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-table .card-header .badge-count {
        background: #1a6e4a;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
    .card-table .card-header .badge-count.draft-badge {
        background: #7f8c8d;
    }
    .card-table .card-header .badge-count.aktif-badge {
        background: #f39c12;
    }
    .card-table .card-header .badge-count.selesai-badge {
        background: #27ae60;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px;
        }
        .dashboard-header h4 {
            font-size: 18px;
        }
        .widget-card {
            padding: 15px 20px;
        }
        .widget-card h2 {
            font-size: 24px;
        }
        .widget-card .widget-icon {
            font-size: 28px;
        }
        .table-dashboard {
            font-size: 12px;
        }
        .table-dashboard thead th,
        .table-dashboard tbody td {
            padding: 8px 10px;
        }
        .btn-action {
            font-size: 10px;
            padding: 2px 8px;
        }
        .btn-permohonan-baru {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div>
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4>Dashboard Pemohon</h4>  
                <p>Laboratorium Penguji Mutu Alsintan UPTD BMSPP</p>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="bi bi-person-circle me-1"></i> 
                    {{ Auth::user()->name ?? 'Pemohon' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Widget Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="widget-card widget-draft">
                <div class="widget-icon">
                    <i class="bi bi-file-earmark"></i>
                </div>
                <h6>Draft</h6>
                <h2>{{ $draft ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card widget-aktif">
                <div class="widget-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <h6>Permohonan Aktif</h6>
                <h2>{{ $permohonanAktif ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card widget-selesai">
                <div class="widget-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h6>Permohonan Selesai</h6>
                <h2>{{ $permohonanSelesai ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Tombol Permohonan Baru -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('permohonan.create') }}" class="btn-permohonan-baru">
                <i class="bi bi-plus-circle"></i> Permohonan Baru
            </a>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABEL DRAFT (UNTUK PEMOHON) -->
    <!-- ============================================ -->
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header" style="background: linear-gradient(135deg, #d8dbdc 0%, #7f8c8d 100%)">
                    <span><i class="bi bi-file-earmark me-2" style=""></i>Draft</span>
                </div>
                <div class="card-body">
                    <table class="table table-dashboard table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Permohonan</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Alsintan</th>
                                <th>Permohonan</th>
                                <th>Validasi</th>
                                <th>Pengujian</th>
                                <th>Test Report</th>
                                <th>Kuisioner</th>
                                <th style="width: 60px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($draftPermohonans as $p)
                            <tr class="clickable-row" data-href="{{ route('permohonan.show', $p->id) }}">
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark" onclick="event.stopPropagation();">
                                        {{ $p->nomor_surat_permohonan ?? 'PMH-'.str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>{{ $p->tanggal_surat_permohonan ? \Carbon\Carbon::parse($p->tanggal_surat_permohonan)->format('d M Y') : $p->created_at->format('d M Y') }}</td>
                                <td>
                                    <div>{{ $p->nama_pemohon ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $p->status_pemohon ?? 'Pemohon' }}</small>
                                </td>
                                <td>
                                    <div>{{ $p->jenis_alsintan ?? '-' }}</div>
                                    <small class="text-muted">{{ $p->merek_model_tipe ?? '' }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-warning-action btn-action" onclick="event.stopPropagation();">
                                        <i class="blink-dot dot-warning"></i> Edit
                                    </a>
                                </td>
                                <td>
                                    <span class="badge-status badge-draft">
                                        <span class="status-dot dot-draft"></span> Draft
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status badge-draft">
                                        <span class="status-dot dot-draft"></span> Draft
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status badge-draft">
                                        <span class="status-dot dot-draft"></span> Draft
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status badge-draft">
                                        <span class="status-dot dot-draft"></span> Draft
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('draft.destroy', $p->id) }}" method="POST" 
                                        onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus draft ini? Semua data akan hilang permanen.');"
                                        onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus Draft">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="bi bi-file-earmark"></i>
                                        <p>Belum ada draft permohonan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABEL PERMOHONAN AKTIF -->
    <!-- ============================================ -->
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header" style="background: linear-gradient(135deg, #fff0e3 0%, #f39c12 100%)">
                    <span><i class="bi bi-hourglass-split me-2"></i>Permohonan Aktif</span>
                </div>
                <div class="card-body">
                    <table class="table table-dashboard table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Permohonan</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Alsintan</th>
                                <th>Permohonan</th>
                                <th>Validasi</th>
                                <th>Pengujian</th>
                                <th>Test Report</th>
                                <th>Kuisioner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktifPermohonans as $p)
                            @php
                                // Cek status persetujuan pengujian
                                $pengujianDisetujui = $p->pengujian_disetujui ?? false;
                                $pengujianDitolak = $p->pengujian_ditolak ?? false;
                                $menungguPersetujuan = $p->pengujian_selesai && !$pengujianDisetujui && !$pengujianDitolak;
                            @endphp
                            <tr class="clickable-row" data-href="{{ route('permohonan.show', $p->id) }}">
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark" onclick="event.stopPropagation();">
                                        {{ $p->nomor_surat_permohonan ?? 'PMH-'.str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>{{ $p->tanggal_surat_permohonan ? \Carbon\Carbon::parse($p->tanggal_surat_permohonan)->format('d M Y') : $p->created_at->format('d M Y') }}</td>
                                <td>
                                    <div>{{ $p->nama_pemohon ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $p->status_pemohon ?? 'Pemohon' }}</small>
                                </td>
                                <td>
                                    <div>{{ $p->jenis_alsintan ?? '-' }}</div>
                                    <small class="text-muted">{{ $p->merek_model_tipe ?? '' }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-success btn-action" onclick="event.stopPropagation();">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    @if($p->validasi)
                                        <a href="{{ route('validasi.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="badge-status badge-warning">
                                            <span class="status-dot dot-warning"></span> Diproses
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($menungguPersetujuan)
                                        <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-warning btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Persetujuan
                                        </a>
                                    @elseif($pengujianDisetujui)
                                        <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @elseif($p->validasi)
                                        <span class="badge-status badge-warning">
                                            <span class="status-dot dot-warning"></span> Diproses
                                        </span>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->testReport)
                                        <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @elseif($menungguPersetujuan)
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
                                        </span>
                                    @elseif($pengujianDisetujui)
                                        <span class="badge-status badge-warning">
                                            <span class="status-dot dot-warning"></span> Diproses
                                        </span>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->testReport)
                                        <a href="{{ route('kuisioner.create', $p->id) }}" class="btn btn-sm btn-warning btn-action" onclick="event.stopPropagation();">
                                            <i class="blink-dot dot-warning"></i> Isi
                                        </a>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Terkunci
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada permohonan aktif</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABEL PERMOHONAN SELESAI -->
    <!-- ============================================ -->
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header" style="background: linear-gradient(135deg, #c9f9df 0%, #2ecc71 100%)">
                    <span><i class="bi bi-check-circle me-2"></i>Permohonan Selesai</span>
                </div>
                <div class="card-body">
                    <table class="table table-dashboard table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Permohonan</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Alsintan</th>
                                <th>Permohonan</th>
                                <th>Validasi</th>
                                <th>Pengujian</th>
                                <th>Test Report</th>
                                <th>Kuisioner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selesaiPermohonans as $p)
                            <tr class="clickable-row" data-href="{{ route('permohonan.show', $p->id) }}">
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark" onclick="event.stopPropagation();">
                                        {{ $p->nomor_surat_permohonan ?? 'PMH-'.str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>{{ $p->tanggal_surat_permohonan ? \Carbon\Carbon::parse($p->tanggal_surat_permohonan)->format('d M Y') : $p->created_at->format('d M Y') }}</td>
                                <td>
                                    <div>{{ $p->nama_pemohon ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $p->status_pemohon ?? 'Pemohon' }}</small>
                                </td>
                                <td>
                                    <div>{{ $p->jenis_alsintan ?? '-' }}</div>
                                    <small class="text-muted">{{ $p->merek_model_tipe ?? '' }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-success btn-action" onclick="event.stopPropagation();">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    @if($p->validasi)
                                        <a href="{{ route('validasi.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="badge-status badge-success">
                                            <span class="status-dot dot-success"></span> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->pengujian)
                                        <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="badge-status badge-success">
                                            <span class="status-dot dot-success"></span> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->testReport)
                                        <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-danger btn-action" disabled style="background: #fce4ec; color: #c62828; border: 1px solid #ef9a9a; cursor: not-allowed; opacity: 1;">
                                            <i class="bi bi-x-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->kuisioner)
                                        <a href="{{ route('kuisioner.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-danger btn-action" disabled style="background: #fce4ec; color: #c62828; border: 1px solid #ef9a9a; cursor: not-allowed; opacity: 1;">
                                            <i class="bi bi-x-circle"></i> Ditolak
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="bi bi-check-circle"></i>
                                        <p>Belum ada permohonan selesai</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection