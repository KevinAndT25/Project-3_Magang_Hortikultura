@extends('layouts.app')

@section('title', 'Dashboard Pemohon')

@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">Dashboard Pemohon</h3>
    </div>
    <!-- Widget 1 -->
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Permohonan</h5>
                <h2 class="card-text">{{ $totalPermohonan }}</h2>
            </div>
        </div>
    </div>
    <!-- Widget 2 -->
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Sedang Diproses</h5>
                <h2 class="card-text">{{ $sedangDiproses }}</h2>
            </div>
        </div>
    </div>
    <!-- Widget 3 -->
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Permohonan Selesai</h5>
                <h2 class="card-text">{{ $selesai }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Tombol Permohonan Baru -->
<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('permohonan.create') }}" class="btn btn-primary btn-lg">+ Permohonan Baru</a>
    </div>
</div>

<!-- Tabel Permohonan Saya -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Daftar Permohonan Saya
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Pemohon</th>
                            <th>Permohonan</th>
                            <th>Validasi</th>
                            <th>Pengujian</th>
                            <th>Test Report</th>
                            <th>Kuisioner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permohonans as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d-m-Y') }}</td>
                            <td>{{ $p->nama_pemohon }}</td>
                            <td>
                                <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            </td>
                            <td>
                                @if($p->validasi_selesai)
                                    <a href="{{ route('validasi.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($p->pengujian_selesai)
                                    <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($p->test_report_selesai)
                                    @if($p->kuisioner_selesai)
                                        <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success">Download</a>
                                    @else
                                        <span class="badge bg-warning">Kuisioner wajib diisi</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($p->test_report_selesai && !$p->kuisioner_selesai)
                                    <a href="{{ route('kuisioner.create', $p->id) }}" class="btn btn-sm btn-primary">Isi Kuisioner</a>
                                @elseif($p->kuisioner_selesai)
                                    <a href="{{ route('kuisioner.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada permohonan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection