@extends('layouts.app')

@section('title', 'Pengujian')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Form Pengujian</h3>
        <p><strong>Permohonan:</strong> {{ $permohonan->nomor_permohonan ?? 'Belum ada nomor' }} - {{ $permohonan->nama_pemohon }}</p>
        <hr>
        <form method="POST" action="{{ route('pengujian.store', $permohonan->id) }}">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nomor_permohonan_uji" class="form-label">Berdasarkan Permohonan Uji No.</label>
                        <input type="text" class="form-control" id="nomor_permohonan_uji" name="nomor_permohonan_uji" value="{{ $permohonan->nomor_permohonan ?? '' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengujian" class="form-label">Tanggal Pengujian</label>
                        <input type="date" class="form-control" id="tanggal_pengujian" name="tanggal_pengujian" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Pengujian</button>
            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection