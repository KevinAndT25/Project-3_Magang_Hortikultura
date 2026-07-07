@extends('layouts.app')

@section('title', 'Permohonan Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Form Permohonan Baru</h3>
        <hr>
        <form method="POST" action="{{ route('permohonan.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Data Pemohon Uji -->
            <div class="card mb-3">
                <div class="card-header">Data Pemohon Uji</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_pemohon" class="form-label">Nama Pemohon Uji</label>
                        <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" required>
                    </div>
                    <div class="mb-3">
                        <label for="status_pemohon" class="form-label">Status Pemohon</label>
                        <select class="form-select" id="status_pemohon" name="status_pemohon" required>
                            <option value="">Pilih Status</option>
                            <option value="UMKM">Bengkel Pengrajin Alsintan (UMKM) / Pembeli / Pengguna</option>
                            <option value="Pemerintah">Instansi Pemerintah</option>
                            <option value="Produsen">Produsen / Distributor / Penyedia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="perusahaan_instansi" class="form-label">Perusahaan/Instansi Pemohon</label>
                        <input type="text" class="form-control" id="perusahaan_instansi" name="perusahaan_instansi">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_surat_permohonan" class="form-label">Nomor / Tanggal Surat Permohonan</label>
                        <input type="text" class="form-control" id="nomor_surat_permohonan" name="nomor_surat_permohonan" placeholder="Contoh: 001/BMSPP/2024" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_surat_permohonan" class="form-label">Tanggal Surat</label>
                        <input type="date" class="form-control" id="tanggal_surat_permohonan" name="tanggal_surat_permohonan" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Alsintan -->
            <div class="card mb-3">
                <div class="card-header">Informasi Alsintan yang akan diuji</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="jenis_alsintan" class="form-label">Jenis Alsintan</label>
                        <input type="text" class="form-control" id="jenis_alsintan" name="jenis_alsintan" required>
                    </div>
                    <div class="mb-3">
                        <label for="status_alsintan" class="form-label">Status Alsintan</label>
                        <select class="form-select" id="status_alsintan" name="status_alsintan" required>
                            <option value="prototipe">Prototipe</option>
                            <option value="produk_massal">Produk Massal</option>
                            <option value="impor">Impor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_produksi" class="form-label">Status Produksi Alsintan</label>
                        <select class="form-select" id="status_produksi" name="status_produksi" required>
                            <option value="produk_lokal">Produk Lokal</option>
                            <option value="impor">Impor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="merek_model_tipe" class="form-label">Merek / Model / Tipe</label>
                        <input type="text" class="form-control" id="merek_model_tipe" name="merek_model_tipe" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" min="1900" max="{{ date('Y') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_unit" class="form-label">Jumlah Alsintan yang diuji (unit)</label>
                        <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" min="1" required>
                    </div>

                    <h5>Spesifikasi Umum</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Motor Penggerak</h6>
                            <div class="mb-2">
                                <label for="daya_maksimal" class="form-label">Daya Maksimal (Hp/kW)</label>
                                <input type="text" class="form-control" id="daya_maksimal" name="daya_maksimal">
                            </div>
                            <div class="mb-2">
                                <label for="putaran_mesin" class="form-label">Putaran Mesin (RPM)</label>
                                <input type="text" class="form-control" id="putaran_mesin" name="putaran_mesin">
                            </div>
                            <div class="mb-2">
                                <label for="bahan_bakar" class="form-label">Bahan Bakar</label>
                                <input type="text" class="form-control" id="bahan_bakar" name="bahan_bakar">
                            </div>
                            <div class="mb-2">
                                <label for="sistem_pendinginan" class="form-label">Sistem Pendinginan</label>
                                <input type="text" class="form-control" id="sistem_pendinginan" name="sistem_pendinginan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Unit Alat</h6>
                            <div class="mb-2">
                                <label for="dimensi" class="form-label">Dimensi (P x L x T)</label>
                                <input type="text" class="form-control" id="dimensi" name="dimensi">
                            </div>
                            <div class="mb-2">
                                <label for="berat" class="form-label">Berat (kg)</label>
                                <input type="text" class="form-control" id="berat" name="berat">
                            </div>
                            <div class="mb-2">
                                <label for="kapasitas_kerja" class="form-label">Kapasitas Kerja</label>
                                <input type="text" class="form-control" id="kapasitas_kerja" name="kapasitas_kerja">
                            </div>
                            <div class="mb-2">
                                <label for="perlengkapan" class="form-label">Perlengkapan</label>
                                <input type="text" class="form-control" id="perlengkapan" name="perlengkapan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persyaratan Upload (conditional) -->
            <div class="card mb-3">
                <div class="card-header">Persyaratan Permohonan Uji</div>
                <div class="card-body" id="upload-fields">
                    <div class="mb-3" id="field-surat">
                        <label for="file_surat_permohonan" class="form-label">Surat Permohonan Pengujian (PDF, JPG, JPEG, DOC)</label>
                        <input type="file" class="form-control" id="file_surat_permohonan" name="file_surat_permohonan" accept=".pdf,.doc,.docx,.jpg,.jpeg">
                    </div>
                    <div class="mb-3 d-none" id="field-akte">
                        <label for="file_akte" class="form-label">Akte Pendirian Perusahaan dan Perubahannya</label>
                        <input type="file" class="form-control" id="file_akte" name="file_akte" accept=".pdf,.jpg,.jpeg">
                    </div>
                    <div class="mb-3 d-none" id="field-ktp">
                        <label for="file_ktp" class="form-label">KTP Pemohon</label>
                        <input type="file" class="form-control" id="file_ktp" name="file_ktp" accept=".pdf,.jpg,.jpeg">
                    </div>
                    <div class="mb-3 d-none" id="field-npwp">
                        <label for="file_npwp" class="form-label">NPWP</label>
                        <input type="file" class="form-control" id="file_npwp" name="file_npwp" accept=".pdf,.jpg,.jpeg">
                    </div>
                    <div class="mb-3 d-none" id="field-nib">
                        <label for="file_nib" class="form-label">NIB (Nomor Induk Berusaha)</label>
                        <input type="file" class="form-control" id="file_nib" name="file_nib" accept=".pdf,.jpg,.jpeg">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Permohonan</button>
            <a href="{{ route('dashboard.pemohon') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status_pemohon');
        const fieldSurat = document.getElementById('field-surat');
        const fieldAkte = document.getElementById('field-akte');
        const fieldKtp = document.getElementById('field-ktp');
        const fieldNpwp = document.getElementById('field-npwp');
        const fieldNib = document.getElementById('field-nib');

        function updateFields() {
            const status = statusSelect.value;
            // Reset semua jadi hidden
            fieldSurat.classList.remove('d-none');
            fieldAkte.classList.add('d-none');
            fieldKtp.classList.add('d-none');
            fieldNpwp.classList.add('d-none');
            fieldNib.classList.add('d-none');

            // Set required attribute sesuai status
            // Surat selalu wajib
            document.getElementById('file_surat_permohonan').required = true;

            if (status === 'UMKM') {
                fieldKtp.classList.remove('d-none');
                document.getElementById('file_ktp').required = true;
                document.getElementById('file_akte').required = false;
                document.getElementById('file_npwp').required = false;
                document.getElementById('file_nib').required = false;
            } else if (status === 'Pemerintah') {
                // hanya surat
                document.getElementById('file_ktp').required = false;
                document.getElementById('file_akte').required = false;
                document.getElementById('file_npwp').required = false;
                document.getElementById('file_nib').required = false;
            } else if (status === 'Produsen') {
                fieldAkte.classList.remove('d-none');
                fieldKtp.classList.remove('d-none');
                fieldNpwp.classList.remove('d-none');
                fieldNib.classList.remove('d-none');
                document.getElementById('file_akte').required = true;
                document.getElementById('file_ktp').required = true;
                document.getElementById('file_npwp').required = true;
                document.getElementById('file_nib').required = true;
            }
        }

        statusSelect.addEventListener('change', updateFields);
        // Trigger awal
        updateFields();
    });
</script>
@endsection