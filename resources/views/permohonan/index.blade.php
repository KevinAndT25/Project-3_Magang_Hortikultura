@extends('layouts.app')

@section('title', 'Daftar Permohonan')

@section('content')
<style>
    .section-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 16px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 3px solid #1a6e4a;
        display: inline-block;
    }
    
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-table .card-body {
        padding: 0;
        overflow-x: auto;
    }
    
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
    .table-dashboard tbody tr:hover {
        background: #f8f9fa;
    }
    
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
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
    
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
    
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background: #f0f2f5 !important;
    }
    
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
</style>

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Daftar Permohonan</h4>
        @if(auth()->user()->isPemohon())
            <a href="{{ route('permohonan.create') }}" class="btn-permohonan-baru">
                <i class="bi bi-plus-circle"></i> Permohonan Baru
            </a>
        @endif
    </div>

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
                    @forelse($permohonans as $p)
                    <tr class="clickable-row" data-href="{{ route('permohonan.show', $p->id) }}">
                        <td>
                            <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark" onclick="event.stopPropagation();">
                                {{ $p->no_permohonan ?? 'PMH-'.str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td>{{ $p->tanggal_permohonan ? \Carbon\Carbon::parse($p->tanggal_permohonan)->format('d M Y') : $p->created_at->format('d M Y') }}</td>
                        <td>
                            <div>{{ $p->user->name ?? $p->nama_pemohon ?? 'Unknown' }}</div>
                            <small class="text-muted">{{ $p->jenis_pemohon ?? 'Pemohon' }}</small>
                        </td>
                        <td>
                            <div>{{ $p->jenis_alsintan ?? '-' }}</div>
                            <small class="text-muted">{{ $p->merk_model_tipe ?? '' }}</small>
                        </td>
                        <td>
                            <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-primary btn-action" onclick="event.stopPropagation();">
                                <i class="bi bi-eye"></i> TDR
                            </a>
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
                            @if($p->kuisioner_selesai)
                                <span class="badge-status badge-success">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
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
                                <p>Belum ada permohonan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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