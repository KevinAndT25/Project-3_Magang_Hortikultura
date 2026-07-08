@extends('layouts.app')

@section('title', 'Daftar Permohonan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Daftar Permohonan</h4>
            <a href="{{ route('permohonan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Permohonan Baru
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Tanggal</th>
                            <th>Jenis Alsintan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permohonans as $p)
                        <tr>
                            <td>PMH-{{ str_pad($p->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $p->created_at->format('d-m-Y') }}</td>
                            <td>{{ $p->jenis_alsintan }}</td>
                            <td>
                                @if($p->validasi_selesai && $p->pengujian_selesai && $p->test_report_selesai && $p->kuisioner_selesai)
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($p->validasi_selesai && $p->pengujian_selesai)
                                    <span class="badge bg-warning">Menunggu Test Report</span>
                                @elseif($p->validasi_selesai)
                                    <span class="badge bg-info">Menunggu Pengujian</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu Validasi</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada permohonan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection