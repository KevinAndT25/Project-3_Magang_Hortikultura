@extends('layouts.app')

@section('title', 'Validasi Permohonan')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Form Validasi Permohonan</h3>
        <p><strong>Permohonan:</strong> {{ $permohonan->nomor_permohonan ?? 'Belum ada nomor' }} - {{ $permohonan->nama_pemohon }}</p>
        <hr>
        <form method="POST" action="{{ route('validasi.store', $permohonan->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="file_kaji_ulang" class="form-label">Upload File Kaji Ulang Permintaan Pengujian dan Kontrak (PDF, JPG, JPEG, DOC, boleh lebih dari satu)</label>
                        <input type="file" class="form-control" id="file_kaji_ulang" name="file_kaji_ulang[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg" required>
                        <small class="text-muted">Anda dapat memilih beberapa file sekaligus (Ctrl+klik).</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Validasi</button>
            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection