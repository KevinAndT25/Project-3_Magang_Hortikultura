@extends('layouts.app')

@section('title', 'Daftar Permohonan')

@section('content')
<style>
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
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
    .card-table .card-header .badge-count.draft-badge {
        background: #717e7f;
    }
    .card-table .card-header .badge-count.aktif-badge {
        background: #e99611;
    }
    .card-table .card-header .badge-count.selesai-badge {
        background: #2bc26a;
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
        background: #f8f9fa !important;
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
    .badge-status.badge-active {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
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
    .btn-action.btn-urgent {
        background: #fce4ec;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }
    .btn-action.btn-urgent:hover {
        background: #f8d7da;
        color: #721c24;
    }
    .btn-action.btn-warning-action {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
    }
    .btn-action.btn-warning-action:hover {
        background: #ffe69c;
    }
    
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
    
    /* Clickable Row */
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background: #f0f2f5 !important;
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
    
    /* Blinking Dot untuk indikator urgent */
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.2; }
        100% { opacity: 1; }
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
    
    /* Legend */
    .legend-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
        padding: 10px 0 20px 0;
        font-size: 12px;
        color: #7f8c8d;
    }
    .legend-section .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .legend-section .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .legend-section .legend-dot.urgent {
        background: #f39c12;
        animation: blink 1s infinite;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px;
        }
        .dashboard-header h4 {
            font-size: 18px;
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
        .card-table .card-header {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start;
        }
    }
</style>

<div>
    <!-- Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class="bi bi-file-earmark-text me-2"></i>Daftar Permohonan</h4>
                <p class="mb-0" style="font-size: 14px;">
                    {{ auth()->user()->isAdmin() ? 'Semua permohonan yang telah disubmit' : 'Semua permohonan Anda' }}
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="bi bi-person-circle me-1"></i> 
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </div>
        </div>
    </div>
    
    @if(auth()->user()->isPemohon())
        <div class="d-flex align-items-center mb-4 flex-wrap">
                <a href="{{ route('permohonan.create') }}" class="btn-permohonan-baru">
                    <i class="bi bi-plus-circle"></i> Permohonan Baru
                </a>
        </div>
    @endif

    <!-- ============================================ -->
    <!-- TABEL DRAFT (HANYA UNTUK PEMOHON) -->
    <!-- ============================================ -->
    @if(auth()->user()->isPemohon())
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header" style="background: linear-gradient(135deg, #d8dbdc 0%, #7f8c8d 100%)">
                    <span><i class="bi bi-file-earmark me-2"></i>Draft</span>
                    <span class="badge-count draft-badge">{{ $draftPermohonans->count() }}</span>
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
    @endif

    <!-- ============================================ -->
    <!-- TABEL PERMOHONAN AKTIF -->
    <!-- ============================================ -->
    @if(auth()->user()->isAdmin())
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
                                <th style="width: 60px;">Aksi</th>
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
                            <tr class="clickable-row {{ (!$p->validasi_selesai || !$p->pengujian_selesai || !$p->test_report_selesai) ? 'tr-highlight' : '' }}" 
                                data-href="{{ route('permohonan.show', $p->id) }}">
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
                                    @if($p->validasi_selesai)
                                        <a href="{{ route('validasi.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @else
                                        <a href="{{ route('validasi.create', $p->id) }}" class="btn btn-sm btn-warning-action btn-action btn-urgent" onclick="event.stopPropagation();">
                                            <span class="blink-dot dot-warning"></span> Isi
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($p->pengujian_selesai)
                                        <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @elseif($p->validasi_selesai)
                                        <a href="{{ route('pengujian.create', $p->id) }}" class="btn btn-sm btn-warning-action btn-action btn-urgent" onclick="event.stopPropagation();">
                                            <span class="blink-dot dot-warning"></span> Isi
                                        </a>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Terkunci
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->test_report_selesai)
                                        <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-check-circle"></i> Lihat
                                        </a>
                                    @elseif($pengujianDitolak)
                                        {{-- Jika pengujian ditolak, permohonan selesai --}}
                                        <span class="badge-status badge-danger" style="background: #fce4ec; color: #c62828;">
                                            <i class="bi bi-x-circle"></i> Ditolak
                                        </span>
                                    @elseif($menungguPersetujuan)
                                        {{-- Menunggu persetujuan pemohon --}}
                                        <span class="badge-status badge-warning" style="background: #fff3cd; color: #856404;">
                                            <span class="status-dot dot-warning"></span> Menunggu
                                        </span>
                                    @elseif($pengujianDisetujui)
                                        {{-- Pengujian disetujui, bisa lanjut ke Test Report --}}
                                        <a href="{{ route('testreport.create', $p->id) }}" class="btn btn-sm btn-warning-action btn-action btn-urgent" onclick="event.stopPropagation();">
                                            <span class="blink-dot dot-warning"></span> Isi
                                        </a>
                                    @elseif($p->pengujian_selesai)
                                        {{-- Pengujian selesai tapi belum ada status persetujuan --}}
                                        <span class="badge-status badge-warning">
                                            <span class="status-dot dot-warning"></span> Menunggu
                                        </span>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Terkunci
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->kuisioner_selesai)
                                        <a href="{{ route('kuisioner.show', $p->id) }}" class="btn btn-sm btn-info btn-action" onclick="event.stopPropagation();">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    @elseif($p->test_report_selesai)
                                        <span class="badge-status badge-warning">
                                            <span class="status-dot dot-warning"></span> Menunggu
                                        </span>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('permohonan.destroy', $p->id) }}" method="POST" 
                                        onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus permohonan ini? Semua data terkait akan hilang permanen.');"
                                        onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus Permohonan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10">
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
    @elseif(auth()->user()->isPemohon())
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header" style="background: linear-gradient(135deg, #fff0e3 0%, #f39c12 100%)">
                    <span><i class="bi bi-hourglass-split me-2"></i>Permohonan Aktif</span>
                    <span class="badge-count aktif-badge">{{ $aktifPermohonans->count() }}</span>
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
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->pengujian)
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
                                    @elseif($p->pengujian)
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
                                        <a href="{{ route('kuisioner.create', $p->id) }}" class="btn btn-sm btn-warning-action btn-action" onclick="event.stopPropagation();">
                                            <i class="blink-dot dot-warning"></i> Isi
                                        </a>
                                    @else
                                        <span class="badge-status badge-waiting">
                                            <span class="status-dot dot-secondary"></span> Menunggu
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
    @endif

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clickable row
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                const href = this.dataset.href;
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endsection 