@extends('layouts.app')

@section('title', 'Detail Validasi')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Detail Validasi</h3>
        <p><strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_permohonan }}</p>
        <hr>
        <div class="card">
            <div class="card-body">
                <h5>File Kaji Ulang & Kontrak</h5>
                @if($validasi && $validasi->file_kaji_ulang_multiple)
                    @foreach($validasi->file_kaji_ulang_multiple as $file)
                        <div>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-pdf"></i> Download File
                            </a>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada file yang diunggah.</p>
                @endif
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection