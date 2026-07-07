@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard Pemohon</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="#" class="btn btn-primary">Permohonan Baru</a>
        </div>

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
                    <td><span class="badge bg-{{ $p->nomor_permohonan ? 'success' : 'warning' }}">{{ $p->nomor_permohonan ? '✔' : '⏳' }}</span></td>
                    <td><span class="badge bg-{{ $p->validasi_selesai ? 'success' : 'secondary' }}">{{ $p->validasi_selesai ? '✔' : '⏳' }}</span></td>
                    <td><span class="badge bg-{{ $p->pengujian_selesai ? 'success' : 'secondary' }}">{{ $p->pengujian_selesai ? '✔' : '⏳' }}</span></td>
                    <td><span class="badge bg-{{ $p->test_report_selesai ? 'success' : 'secondary' }}">{{ $p->test_report_selesai ? '✔' : '⏳' }}</span></td>
                    <td><span class="badge bg-{{ $p->kuisioner_selesai ? 'success' : 'secondary' }}">{{ $p->kuisioner_selesai ? '✔' : '⏳' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada permohonan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection