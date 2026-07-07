@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard Admin</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Permohonan Aktif</h5>
                        <p class="card-text display-4">{{ $permohonans->where('test_report_selesai', false)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Permohonan Selesai</h5>
                        <p class="card-text display-4">{{ $permohonans->where('test_report_selesai', true)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter (nanti) -->
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Cari nama pemohon / alsintan...">
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Pemohon</th>
                    <th>Status Pemohon</th>
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
                    <td>{{ $p->status_pemohon }}</td>
                    <td><span class="badge bg-{{ $p->nomor_permohonan ? 'success' : 'warning' }}">{{ $p->nomor_permohonan ? '✔' : '⏳' }}</span></td>
                    <td>
                        @if($p->validasi_selesai)
                            <span class="badge bg-success">✔</span>
                        @else
                            <a href="#" class="btn btn-sm btn-primary">Upload</a>
                        @endif
                    </td>
                    <td>
                        @if($p->pengujian_selesai)
                            <span class="badge bg-success">✔</span>
                        @else
                            <a href="#" class="btn btn-sm btn-primary">Isi</a>
                        @endif
                    </td>
                    <td>
                        @if($p->test_report_selesai)
                            <span class="badge bg-success">✔</span>
                        @else
                            <a href="#" class="btn btn-sm btn-primary">Upload</a>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $p->kuisioner_selesai ? 'success' : 'secondary' }}">{{ $p->kuisioner_selesai ? '✔' : '⏳' }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Belum ada permohonan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection