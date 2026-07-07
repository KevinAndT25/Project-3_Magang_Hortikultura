@extends('layouts.app')

@section('title', 'Detail Kuisioner')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Detail Kuisioner</h3>
        <p><strong>Permohonan:</strong> {{ $permohonan->nomor_permohonan }}</p>
        <hr>
        @if($kuisioner)
        <div class="card">
            <div class="card-body">
                <h5>Profil Responden</h5>
                <table class="table table-bordered">
                    <tr><th>Nama</th><td>{{ $kuisioner->nama_responden }}</td></tr>
                    <tr><th>Telepon</th><td>{{ $kuisioner->telepon_responden }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $kuisioner->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><th>Usia</th><td>{{ $kuisioner->usia }} tahun</td></tr>
                    <tr><th>Pendidikan Terakhir</th><td>{{ $kuisioner->pendidikan_terakhir }}</td></tr>
                    <tr><th>Perusahaan/Instansi</th><td>{{ $kuisioner->nama_perusahaan_instansi }}</td></tr>
                    <tr><th>Alamat Perusahaan</th><td>{{ $kuisioner->alamat_perusahaan }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $kuisioner->jabatan }}</td></tr>
                    <tr><th>Lama Bekerja</th><td>{{ $kuisioner->lama_bekerja_tahun }} tahun</td></tr>
                </table>

                <h5>Informasi Umum</h5>
                <table class="table table-bordered">
                    <tr><th>Pengujian Pertama?</th><td>{{ $kuisioner->pengujian_pertama ? 'Ya' : 'Tidak' }}</td></tr>
                    @if(!$kuisioner->pengujian_pertama)
                        <tr><th>Pengujian ke-</th><td>{{ $kuisioner->pengujian_ke }}</td></tr>
                    @endif
                    <tr><th>Mewakili</th><td>{{ $kuisioner->mewakili == 'diri_sendiri' ? 'Diri Sendiri' : 'Perusahaan' }}</td></tr>
                    <tr><th>Terakhir Mengajukan</th><td>{{ $kuisioner->terakhir_mengajukan ?? '-' }}</td></tr>
                    <tr><th>Unit Layanan</th><td>{{ str_replace('_', ' ', $kuisioner->unit_layanan) }}</td></tr>
                    <tr><th>Hari Laporan Keluar</th><td>{{ $kuisioner->hari_laporan_keluar }} hari</td></tr>
                </table>

                <h5>Penilaian Servqual</h5>
                <table class="table table-bordered">
                    <tr><th>Pelayanan kepada konsumen</th><td>{{ $kuisioner->servqual_1 }}</td></tr>
                    <tr><th>Keramahan personil</th><td>{{ $kuisioner->servqual_2 }}</td></tr>
                    <tr><th>Ketepatan waktu pengujian</th><td>{{ $kuisioner->servqual_3 }}</td></tr>
                    <tr><th>Kelengkapan alat</th><td>{{ $kuisioner->servqual_4 }}</td></tr>
                    <tr><th>Ketepatan waktu penyerahan laporan uji</th><td>{{ $kuisioner->servqual_5 }}</td></tr>
                </table>
                <p><strong>Kesan Pesan:</strong> {{ $kuisioner->kesan_pesan ?? '-' }}</p>

                <h5>Kepuasan Umum</h5>
                <table class="table table-bordered">
                    <tr><th>Tingkat Kepuasan</th><td>{{ str_replace('_', ' ', $kuisioner->kepuasan_umum) }}</td></tr>
                    <tr><th>Rekomendasi</th><td>{{ str_replace('_', ' ', $kuisioner->rekomendasi) }}</td></tr>
                </table>
                <p><strong>Ide & Saran:</strong> {{ $kuisioner->ide_saran ?? '-' }}</p>
            </div>
        </div>
        @else
            <div class="alert alert-warning">Kuisioner belum diisi.</div>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection