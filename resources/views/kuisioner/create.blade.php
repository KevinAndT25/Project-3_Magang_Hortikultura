@extends('layouts.app')

@section('title', 'Kuisioner Kepuasan')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Kuisioner Kepuasan Pengguna</h3>
        <p><strong>Permohonan:</strong> {{ $permohonan->nomor_permohonan ?? 'Belum ada nomor' }}</p>
        <hr>
        <form method="POST" action="{{ route('kuisioner.store', $permohonan->id) }}">
            @csrf
            <!-- Profil Responden -->
            <div class="card mb-3">
                <div class="card-header">I. Profil Responden</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_responden" class="form-label">Nama Responden</label>
                        <input type="text" class="form-control" id="nama_responden" name="nama_responden" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon_responden" class="form-label">No Telepon Responden</label>
                        <input type="text" class="form-control" id="telepon_responden" name="telepon_responden" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="usia" class="form-label">Usia (tahun)</label>
                        <input type="number" class="form-control" id="usia" name="usia" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                            <option value="tidak_sekolah">Tidak Sekolah</option>
                            <option value="sd">SD/Sederajat</option>
                            <option value="smp">SMP/Sederajat</option>
                            <option value="sma">SMA/Sederajat</option>
                            <option value="akademi">Akademi/Diploma</option>
                            <option value="sarjana">Sarjana/S1</option>
                            <option value="pascasarjana">Pascasarjana/S2</option>
                            <option value="doktoral">Doktoral/S3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_perusahaan_instansi" class="form-label">Nama Perusahaan/Instansi</label>
                        <input type="text" class="form-control" id="nama_perusahaan_instansi" name="nama_perusahaan_instansi" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan/Instansi</label>
                        <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan di Perusahaan</label>
                        <select class="form-select" id="jabatan" name="jabatan" required>
                            <option value="pemilik_owner">Pemilik/Owner</option>
                            <option value="staff">Staff (termasuk direktur, manager, operasional)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lama_bekerja_tahun" class="form-label">Lama Bekerja di Perusahaan/Instansi (tahun)</label>
                        <input type="number" class="form-control" id="lama_bekerja_tahun" name="lama_bekerja_tahun" min="0" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Umum -->
            <div class="card mb-3">
                <div class="card-header">II. Informasi Umum Perihal Pengurusan Pengujian</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="pengujian_pertama" class="form-label">Apakah ini pengujian yang pertama?</label>
                        <select class="form-select" id="pengujian_pertama" name="pengujian_pertama" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="mb-3" id="pengujian_ke_container" style="display:none;">
                        <label for="pengujian_ke" class="form-label">Ini pengujian yang ke-...</label>
                        <input type="number" class="form-control" id="pengujian_ke" name="pengujian_ke" min="2">
                    </div>
                    <div class="mb-3">
                        <label for="mewakili" class="form-label">Dalam proses mengurus izin, anda mewakili</label>
                        <select class="form-select" id="mewakili" name="mewakili" required>
                            <option value="diri_sendiri">Diri sendiri</option>
                            <option value="perusahaan">Perusahaan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="terakhir_mengajukan" class="form-label">Kapan terakhir anda mengajukan permohonan pengujian di LPMA UPTD BMSPP?</label>
                        <input type="text" class="form-control" id="terakhir_mengajukan" name="terakhir_mengajukan" placeholder="Misal: 2023">
                    </div>
                    <div class="mb-3">
                        <label for="unit_layanan" class="form-label">Unit layanan yang anda tuju</label>
                        <select class="form-select" id="unit_layanan" name="unit_layanan" required>
                            <option value="uji_awal">Uji Awal</option>
                            <option value="uji_ulang">Uji Ulang</option>
                            <option value="uji_perpanjangan">Uji Perpanjangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hari_laporan_keluar" class="form-label">Menurut perkiraan berapa hari laporan hasil uji (test report) keluar setelah proses pengujian selesai? (hari)</label>
                        <input type="number" class="form-control" id="hari_laporan_keluar" name="hari_laporan_keluar" min="1" required>
                    </div>
                </div>
            </div>

            <!-- Servqual -->
            <div class="card mb-3">
                <div class="card-header">III. Pertanyaan Servqual/Pengamatan Pelayanan Pengujian Alsintan</div>
                <div class="card-body">
                    <p>Berikan penilaian dengan poin antara 1 s/d 5 (1=Sangat Tidak Puas, 2=Tidak Puas, 3=Netral, 4=Puas, 5=Sangat Puas)</p>
                    <div class="mb-2">
                        <label for="servqual_1">1. Pelayanan kepada konsumen</label>
                        <select class="form-select" id="servqual_1" name="servqual_1" required>
                            @for ($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="servqual_2">2. Keramahan personil</label>
                        <select class="form-select" id="servqual_2" name="servqual_2" required>
                            @for ($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="servqual_3">3. Ketepatan waktu pengujian</label>
                        <select class="form-select" id="servqual_3" name="servqual_3" required>
                            @for ($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="servqual_4">4. Kelengkapan alat</label>
                        <select class="form-select" id="servqual_4" name="servqual_4" required>
                            @for ($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="servqual_5">5. Ketepatan waktu penyerahan laporan uji</label>
                        <select class="form-select" id="servqual_5" name="servqual_5" required>
                            @for ($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kesan_pesan" class="form-label">Kesan Pesan</label>
                        <textarea class="form-control" id="kesan_pesan" name="kesan_pesan" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Kepuasan Umum -->
            <div class="card mb-3">
                <div class="card-header">IV. Kepuasan Secara Umum</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kepuasan_umum" class="form-label">Setelah mengikuti seluruh proses pelayanan pengujian alsintan di LPMA UPTD BMSPP, menurut anda kepuasan yang anda rasakan seperti apa?</label>
                        <select class="form-select" id="kepuasan_umum" name="kepuasan_umum" required>
                            <option value="sangat_tidak_puas">Sangat Tidak Puas</option>
                            <option value="tidak_puas">Tidak Puas</option>
                            <option value="netral">Netral/Biasa Aja</option>
                            <option value="puas">Puas</option>
                            <option value="sangat_puas">Sangat Puas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rekomendasi" class="form-label">Apakah anda bersedia merekomendasikan atau mempromosikan pelayanan pengujian di LPMA UPTD BMSPP?</label>
                        <select class="form-select" id="rekomendasi" name="rekomendasi" required>
                            <option value="sangat_tidak">Sangat Tidak Bersedia Merekomendasikan</option>
                            <option value="tidak">Tidak Bersedia Merekomendasikan</option>
                            <option value="terserah">Terserah yang Bersangkutan</option>
                            <option value="merekomendasikan">Merekomendasikan</option>
                            <option value="sangat_merekomendasikan">Sangat Merekomendasikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ide_saran" class="form-label">Ide dan saran untuk pihak pelayanan pengujian di LPMA UPTD BMSPP</label>
                        <textarea class="form-control" id="ide_saran" name="ide_saran" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Kuisioner</button>
            <a href="{{ route('dashboard.pemohon') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pengujianPertama = document.getElementById('pengujian_pertama');
        const pengujianKeContainer = document.getElementById('pengujian_ke_container');
        const pengujianKeInput = document.getElementById('pengujian_ke');

        pengujianPertama.addEventListener('change', function() {
            if (this.value === '0') {
                pengujianKeContainer.style.display = 'block';
                pengujianKeInput.required = true;
            } else {
                pengujianKeContainer.style.display = 'none';
                pengujianKeInput.required = false;
                pengujianKeInput.value = '';
            }
        });
    });
</script>
@endsection