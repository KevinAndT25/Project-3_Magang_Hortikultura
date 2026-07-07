@extends('layouts.app')

@section('title', 'Detail Pengujian')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Detail Pengujian</h3>
        <p><strong>Nomor Permohonan Uji:</strong> {{ $pengujian->nomor_permohonan_uji ?? $permohonan->nomor_permohonan }}</p>
        <hr>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal Pengujian</th>
                        <td>{{ $pengujian->tanggal_pengujian ? \Carbon\Carbon::parse($pengujian->tanggal_pengujian)->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $pengujian->lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $pengujian->deskripsi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection