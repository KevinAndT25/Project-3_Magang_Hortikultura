@extends('layouts.app')

@section('title', 'Dashboard Pemohon')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        padding: 30px 0;
        border-radius: 12px;
        margin-bottom: 30px;
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
    .dashboard-header h2 {
        font-weight: 700;
        margin-bottom: 5px;
        position: relative;
        z-index: 1;
    }
    .dashboard-header p {
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }
    
    /* Widget Cards */
    .widget-card {
        border-radius: 12px;
        padding: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        border: none;
    }
    .widget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .widget-card .widget-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 40px;
        opacity: 0.2;
    }
    .widget-card h6 {
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 5px;
        font-size: 14px;
    }
    .widget-card h2 {
        font-weight: 700;
        margin-bottom: 0;
        font-size: 32px;
    }
    .widget-total {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
    }
    .widget-proses {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }
    .widget-selesai {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    }
    
    /* Button Permohonan Baru */
    .btn-permohonan-baru {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
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
        font-size: 18px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 3px solid #1a6e4a;
        display: inline-block;
    }
    
    /* Table Styling */
    .table-dashboard {
        font-size: 14px;
    }
    .table-dashboard thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #e0e5ec;
        padding: 12px 15px;
        font-size: 13px;
        white-space: nowrap;
    }
    .table-dashboard tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }
    .table-dashboard tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Badge Status */
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
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
    .badge-status.badge-danger {
        background: #f8d7da;
        color: #721c24;
    }
    
    /* Status Column */
    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 6px;
    }
    .status-dot.dot-success { background: #27ae60; }
    .status-dot.dot-warning { background: #f39c12; }
    .status-dot.dot-danger { background: #e74c3c; }
    .status-dot.dot-secondary { background: #95a5a6; }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #95a5a6;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.3;
    }
    .empty-state p {
        margin-bottom: 0;
        font-size: 15px;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 4px 12px;
        font-size: 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
    .btn-action.btn-sm-action {
        padding: 2px 10px;
        font-size: 11px;
    }
    
    /* Card Table */
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-table .card-header {
        background: white;
        border-bottom: 1px solid #f0f2f5;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 16px;
    }
    .card-table .card-body {
        padding: 0;
        overflow-x: auto;
    }
</style>

<div class="container-fluid">
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Dashboard Pemohon</h2>
                    <p>Laboratorium Penguji Mutu Alsintan UPTD BMSPP</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="bi bi-person-circle me-1"></i> 
                        {{ Auth::user()->name ?? 'Pemohon' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Widget Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="widget-card widget-total">
                    <div class="widget-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h6>Total Permohonan</h6>
                    <h2>{{ $totalPermohonan ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card widget-proses">
                    <div class="widget-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h6>Sedang Diproses</h6>
                    <h2>{{ $sedangDiproses ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card widget-selesai">
                    <div class="widget-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6>Selesai</h6>
                    <h2>{{ $selesai ?? 0 }}</h2>
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

        <!-- Tabel Permohonan Aktif -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="section-title">Permohonan Aktif</h5>
                <div class="card card-table">
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
                                @php
                                    $activePermohonans = isset($permohonans) ? $permohonans->filter(function($p) {
                                        return $p->validasi_selesai != 1 || $p->pengujian_selesai != 1;
                                    }) : collect();
                                @endphp
                                
                                @forelse($activePermohonans as $p)
                                <tr>
                                    <td>
                                        <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark">
                                            PMH-{{ str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>{{ $p->created_at->format('d M Y') }}</td>
                                    <td>{{ $p->nama_pemohon ?? 'user raskn' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $p->alsintan ?? 'Pompa' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-primary btn-action">TDR</a>
                                    </td>
                                    <td>
                                        @if($p->validasi_selesai)
                                            <span class="badge-status badge-success">
                                                <span class="status-dot dot-success"></span> Selesai
                                            </span>
                                        @else
                                            <span class="badge-status badge-waiting">
                                                <span class="status-dot dot-secondary"></span> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->pengujian_selesai)
                                            <span class="badge-status badge-success">
                                                <span class="status-dot dot-success"></span> Selesai
                                            </span>
                                        @else
                                            <span class="badge-status badge-waiting">
                                                <span class="status-dot dot-secondary"></span> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->test_report_selesai)
                                            <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success btn-action">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        @elseif($p->pengujian_selesai && $p->kuisioner_selesai)
                                            <span class="badge-status badge-warning">Menunggu Report</span>
                                        @else
                                            <span class="badge-status badge-waiting">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->test_report_selesai && !$p->kuisioner_selesai)
                                            <a href="{{ route('kuisioner.create', $p->id) }}" class="btn btn-sm btn-primary btn-action">
                                                <i class="bi bi-pencil"></i> Isi
                                            </a>
                                        @elseif($p->kuisioner_selesai)
                                            <span class="badge-status badge-success">
                                                <i class="bi bi-check-circle"></i> Terisi
                                            </span>
                                        @else
                                            <span class="badge-status badge-waiting">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            <p>Tidak ada data permohonan aktif</p>
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

        <!-- Tabel Permohonan Selesai -->
        <div class="row">
            <div class="col-12">
                <h5 class="section-title">Permohonan Selesai</h5>
                <div class="card card-table">
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
                                @php
                                    $completedPermohonans = isset($permohonans) ? $permohonans->filter(function($p) {
                                        return $p->validasi_selesai == 1 && $p->pengujian_selesai == 1;
                                    }) : collect();
                                @endphp
                                
                                @forelse($completedPermohonans as $p)
                                <tr>
                                    <td>
                                        <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark">
                                            PMH-{{ str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>{{ $p->created_at->format('d M Y') }}</td>
                                    <td>{{ $p->nama_pemohon ?? 'user raskn' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $p->alsintan ?? 'Pompa' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-primary btn-action">TDR</a>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-success">
                                            <span class="status-dot dot-success"></span> Selesai
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-success">
                                            <span class="status-dot dot-success"></span> Selesai
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success btn-action">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('kuisioner.show', $p->id) }}" class="btn btn-sm btn-info btn-action">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="bi bi-check-circle"></i>
                                            <p>Tidak ada data permohonan selesai</p>
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
</div>
@endsection