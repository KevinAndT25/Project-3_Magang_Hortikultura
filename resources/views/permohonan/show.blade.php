@extends('layouts.app')

@section('title', 'Detail Permohonan')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Detail Permohonan</h3>
        <p><strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_permohonan }}</p>
        <hr>
        <div class="card">
            <div class="card-body">
                <h5>Data Pemohon</h5>
                <p><strong>Nama:</strong> {{ $permohonan->nama_pemohon }}</p>
                <p><strong>Status:</strong> {{ $permohonan->status_pemohon }}</p>
                <p><strong>Perusahaan:</strong> {{ $permohonan->perusahaan_instansi ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $permohonan->alamat }}</p>
                <p><strong>Telepon:</strong> {{ $permohonan->telepon }}</p>
                <p><strong>Surat:</strong> {{ $permohonan->nomor_surat_permohonan }} ({{ $permohonan->tanggal_surat_permohonan }})</p>
                <hr>
                <h5>Informasi Alsintan</h5>
                <p><strong>Jenis:</strong> {{ $permohonan->jenis_alsintan }}</p>
                <p><strong>Status Alsintan:</strong> {{ $permohonan->status_alsintan }}</p>
                <p><strong>Status Produksi:</strong> {{ $permohonan->status_produksi }}</p>
                <p><strong>Merek/Tipe:</strong> {{ $permohonan->merek_model_tipe }}</p>
                <p><strong>Tahun:</strong> {{ $permohonan->tahun_pembuatan }}</p>
                <p><strong>Jumlah Unit:</strong> {{ $permohonan->jumlah_unit }}</p>
                <h6>Spesifikasi Motor Penggerak</h6>
                <p>Daya: {{ $permohonan->daya_maksimal ?? '-' }}, RPM: {{ $permohonan->putaran_mesin ?? '-' }}, Bahan Bakar: {{ $permohonan->bahan_bakar ?? '-' }}, Pendingin: {{ $permohonan->sistem_pendinginan ?? '-' }}</p>
                <h6>Spesifikasi Unit Alat</h6>
                <p>Dimensi: {{ $permohonan->dimensi ?? '-' }}, Berat: {{ $permohonan->berat ?? '-' }}, Kapasitas: {{ $permohonan->kapasitas_kerja ?? '-' }}, Perlengkapan: {{ $permohonan->perlengkapan ?? '-' }}</p>
                <hr>
                <h5>File Persyaratan</h5>
                @if($permohonan->file_surat_permohonan)
                    <a href="{{ asset('storage/' . $permohonan->file_surat_permohonan) }}" target="_blank">Surat Permohonan</a><br>
                @endif
                @if($permohonan->file_akte)
                    <a href="{{ asset('storage/' . $permohonan->file_akte) }}" target="_blank">Akte</a><br>
                @endif
                @if($permohonan->file_ktp)
                    <a href="{{ asset('storage/' . $permohonan->file_ktp) }}" target="_blank">KTP</a><br>
                @endif
                @if($permohonan->file_npwp)
                    <a href="{{ asset('storage/' . $permohonan->file_npwp) }}" target="_blank">NPWP</a><br>
                @endif
                @if($permohonan->file_nib)
                    <a href="{{ asset('storage/' . $permohonan->file_nib) }}" target="_blank">NIB</a><br>
                @endif
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection