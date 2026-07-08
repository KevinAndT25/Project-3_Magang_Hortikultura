@extends('layouts.app')

@section('title', 'Daftar Permohonan')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Daftar Permohonan</h4>
        @if(auth()->user()->isPemohon())
            <a href="{{ route('permohonan.create') }}" class="btn btn-permohonan-baru">
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permohonans as $p)
                    <tr>
                        <td>
                            <a href="{{ route('permohonan.show', $p->id) }}" class="text-decoration-none fw-semibold text-dark">
                                PMH-{{ str_pad($p->id, 6, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                        <td>{{ $p->user->name ?? $p->nama_pemohon ?? 'Unknown' }}</td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $p->alsintan ?? '-' }}</span>
                        </td>
                        <td>
                            @php
                                $status = 'Menunggu';
                                $badgeClass = 'badge-waiting';
                                if ($p->validasi_selesai && $p->pengujian_selesai && $p->test_report_selesai && $p->kuisioner_selesai) {
                                    $status = 'Selesai';
                                    $badgeClass = 'badge-success';
                                } elseif ($p->validasi_selesai && $p->pengujian_selesai) {
                                    $status = 'Pengujian Selesai';
                                    $badgeClass = 'badge-info';
                                } elseif ($p->validasi_selesai) {
                                    $status = 'Divalidasi';
                                    $badgeClass = 'badge-warning';
                                }
                            @endphp
                            <span class="badge-status {{ $badgeClass }}">
                                <span class="status-dot dot-{{ str_replace('badge-', '', $badgeClass) }}"></span>
                                {{ $status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-primary btn-action">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
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
@endsection