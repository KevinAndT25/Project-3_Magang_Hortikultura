@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h3 class="mb-4">Dashboard Admin</h3>
    </div>
    <!-- Widget 1 -->
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Permohonan</h5>
                <h2 class="card-text">{{ $totalPermohonan }}</h2>
            </div>
        </div>
    </div>
    <!-- Widget 2 -->
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Menunggu Tindakan Admin</h5>
                <h2 class="card-text">{{ $menungguTindakan }}</h2>
            </div>
        </div>
    </div>
    <!-- Widget 3 -->
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Menunggu Kuisioner</h5>
                <h2 class="card-text">{{ $menungguKuisioner }}</h2>
            </div>
        </div>
    </div>
    <!-- Widget 4 -->
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Permohonan Selesai</h5>
                <h2 class="card-text">{{ $selesai }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Permohonan -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Daftar Permohonan</span>
                <div>
                    <input type="text" id="search" class="form-control d-inline-block w-auto" placeholder="Cari nama/alsintan...">
                    <select id="filterStatus" class="form-select d-inline-block w-auto">
                        <option value="">Semua Status</option>
                        <option value="UMKM">UMKM</option>
                        <option value="Pemerintah">Pemerintah</option>
                        <option value="Produsen">Produsen</option>
                    </select>
                </div>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permohonans as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d-m-Y') }}</td>
                            <td>{{ $p->nama_pemohon }}</td>
                            <td>
                                <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            </td>
                            <!-- Kolom Validasi -->
                            <td>
                                @if($p->validasi_selesai)
                                    <a href="{{ route('validasi.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @else
                                    <a href="{{ route('validasi.create', $p->id) }}" class="btn btn-sm btn-warning">Isi</a>
                                @endif
                            </td>

                            <!-- Kolom Pengujian -->
                            <td>
                                @if($p->pengujian_selesai)
                                    <a href="{{ route('pengujian.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @elseif($p->validasi_selesai)
                                    <a href="{{ route('pengujian.create', $p->id) }}" class="btn btn-sm btn-warning">Isi</a>
                                @else
                                    <span class="badge bg-secondary">Terkunci (isi validasi dulu)</span>
                                @endif
                            </td>

                            <!-- Kolom Test Report -->
                            <td>
                                @if($p->test_report_selesai)
                                    <a href="{{ route('testreport.show', $p->id) }}" class="btn btn-sm btn-success">Lihat</a>
                                @elseif($p->pengujian_selesai)
                                    <a href="{{ route('testreport.create', $p->id) }}" class="btn btn-sm btn-warning">Isi</a>
                                @else
                                    <span class="badge bg-secondary">Terkunci (isi pengujian dulu)</span>
                                @endif
                            </td>
                            <td>
                                @if($p->kuisioner_selesai)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('permohonan.show', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection