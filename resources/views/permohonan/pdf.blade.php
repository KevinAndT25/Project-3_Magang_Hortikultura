<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checklist Permohonan Pengujian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            padding: 30px 35px;
            color: #333;
            line-height: 1.5;
        }
        
        /* ============================================
           HEADER / KOP SURAT
           ============================================ */
        .header {
            border-bottom: 3px double #1a6e4a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            padding: 0 5px;
        }
        .header-logo {
            width: 80px;
            text-align: left;
        }
        .header-logo img {
            width: auto;
            height: 90px;
            object-fit: contain;
        }
        .header-text {
            text-align: center;
            padding: 0 10px;
        }
        .header-text .title-main {
            font-size: 18px;
            font-weight: 700;
            color: #1a6e4a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-text .title-sub {
            font-size: 13px;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 2px;
        }
        .header-text .title-instansi {
            font-size: 12px;
            font-weight: 500;
            color: #333;
        }
        .header-text .title-alamat {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }
        .header-right {
            width: 80px;
            text-align: right;
        }
        .header-right img {
            width: auto;
            height: 70px;
            object-fit: contain;
        }
        
        /* ============================================
           JUDUL DOKUMEN
           ============================================ */
        .document-title {
            text-align: center;
            margin: 15px 0 20px 0;
        }
        .document-title h1 {
            font-size: 18px;
            font-weight: 700;
            color: #1a6e4a;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 0;
            border-top: 2px solid #1a6e4a;
            border-bottom: 2px solid #1a6e4a;
            display: inline-block;
        }
        
        .document-info {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
        }
        
        /* ============================================
           SECTION
           ============================================ */
        .section {
            margin-bottom: 22px;
        }
        .section-title {
            font-weight: 700;
            font-size: 14px;
            color: #1a6e4a;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 2px solid #1a6e4a;
        }
        
        /* ============================================
           ROW ITEM DENGAN TITIK DUA SEJAJAR
           ============================================ */
        .row-item {
            display: flex;
            padding: 3px 0;
            border-bottom: 1px dotted #eee;
            align-items: baseline;
        }
        .row-item .label {
            font-weight: 600;
            color: #444;
            width: 220px;
            flex-shrink: 0;
            font-size: 12px;
            text-align: left;
        }
        .row-item .label .colon {
            margin-left: 5px;
        }
        .row-item .value {
            color: #333;
            font-size: 12px;
            flex: 1;
            padding-left: 10px;
        }
        .row-item .value .empty {
            color: #aaa;
            font-style: italic;
        }
        
        /* Sub section (untuk spesifikasi) */
        .sub-section {
            margin-top: 6px;
            margin-left: 10px;
        }
        .sub-section .row-item .label {
            width: 190px;
            font-weight: 500;
            color: #555;
        }
        
        .spec-title {
            font-weight: 600;
            color: #1a6e4a;
            font-size: 12px;
            margin-top: 6px;
            margin-bottom: 3px;
        }
        .spec-title .number {
            font-weight: 700;
        }
        
        /* ============================================
           TABLE CHECKLIST
           ============================================ */
        .table-checklist {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 12px;
        }
        .table-checklist th,
        .table-checklist td {
            border: 1px solid #ddd;
            padding: 6px 10px;
            text-align: left;
        }
        .table-checklist th {
            background: #f0f9f4;
            font-weight: 700;
            color: #1a6e4a;
            text-align: center;
        }
        .table-checklist .check-yes {
            color: #27ae60;
            font-weight: 700;
            text-align: center;
        }
        .table-checklist .check-no {
            color: #e74c3c;
            text-align: center;
        }
        .table-checklist .text-muted {
            color: #999;
            text-align: center;
        }
        .table-checklist .text-center {
            text-align: center;
        }
        
        /* ============================================
           KETERANGAN
           ============================================ */
        .keterangan {
            margin-top: 12px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-left: 4px solid #1a6e4a;
            font-size: 11px;
        }
        .keterangan strong {
            color: #1a6e4a;
        }
        .keterangan ul {
            list-style: none;
            padding-left: 10px;
            margin: 4px 0;
        }
        .keterangan ul li {
            padding: 2px 0;
        }
        .keterangan .highlight {
            color: #1a6e4a;
            font-weight: 600;
        }
        .keterangan .required-note {
            color: #e74c3c;
            font-size: 10px;
            margin-top: 4px;
        }
        
        /* ============================================
           PAGE BREAK - UNTUK HALAMAN KEDUA
           ============================================ */
        .page-break {
            page-break-before: always;
            margin-top: 30px;
            padding-top: 20px;
        }
        
        /* ============================================
           TANDA TANGAN - DENGAN TABEL 2 KOLOM
           ============================================ */
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: bottom;
            padding: 10px 0;
        }
        .signature-table .col-left {
            width: 50%;
        }
        .signature-table .col-right {
            width: 50%;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 250px;
            padding: 0 20px;
        }
        .signature-box .label-sign {
            font-size: 12px;
            font-weight: 600;
            color: #1a6e4a;
            display: block;
            margin-bottom: 8px;
        }
        .signature-box .sign-space {
            height: 60px;
            /* Ruang kosong untuk tanda tangan */
        }
        .signature-box .sign-line {
            padding-top: 6px;
            font-size: 11px;
            color: #555;
        }
        
        /* ============================================
           FOOTER BAWAH
           ============================================ */
        .footer-bottom {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- ================================================================ -->
    <!-- HALAMAN 1 -->
    <!-- ================================================================ -->

    <!-- ============================================ -->
    <!-- KOP SURAT / HEADER -->
    <!-- ============================================ -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <img src="{{ public_path('images/logo-sumbar.png') }}" alt="">
                </td>
                <td class="header-text">
                    <div class="title-main">LABORATORIUM PENGUJI MUTU ALSINTAN</div>
                    <div class="title-sub">UPTD BALAI MEKANISASI DAN SARANA PRASARANA PERTANIAN</div>
                    <div class="title-instansi">DINAS PERKEBUNAN, TANAMAN PANGAN DAN HORTIKULTURA</div>
                    <div class="title-instansi">PROVINSI SUMATERA BARAT</div>
                    <div class="title-alamat">
                        Jln. Syech Djamil Djambek Landbouw Kota Bukittinggi, email : lpma.bmptph@gmail.com
                    </div>
                </td>
                <td class="header-right">
                    <img src="{{ public_path('images/logo-komite.png') }}" alt="">
                </td>
            </tr>
        </table>
    </div>

    <!-- ============================================ -->
    <!-- JUDUL DOKUMEN -->
    <!-- ============================================ -->
    <div class="document-title">
        <h1>CHECKLIST PERMOHONAN PENGUJIAN</h1>
    </div>

    <!-- ============================================ -->
    <!-- INFO DOKUMEN -->
    <!-- ============================================ -->
    <div class="document-info">
        <strong>No. Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
        &nbsp;|&nbsp;
        <strong>Tanggal Cetak:</strong> {{ $tanggal_cetak }}
    </div>

    <!-- ============================================ -->
    <!-- I. DATA PEMOHON UJI -->
    <!-- ============================================ -->
    <div class="section">
        <div class="section-title">I. Data Pemohon Uji</div>
        
        <div class="row-item">
            <span class="label">Nama Pemohon Uji<span class="colon"> :</span></span>
            <span class="value"><strong>{{ $permohonan->nama_pemohon }}</strong></span>
        </div>
        <div class="row-item">
            <span class="label">Status Pemohon<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->status_pemohon }}</span>
        </div>
        <div class="row-item">
            <span class="label">Perusahaan/Instansi Pemohon<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->perusahaan_instansi ?? '-' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Alamat Lengkap Pemohon<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->alamat }}</span>
        </div>
        <div class="row-item">
            <span class="label">Nomor Telepon<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->telepon }}</span>
        </div>
        <div class="row-item">
            <span class="label">No/Tgl Surat Permohonan<span class="colon"> :</span></span>
            <span class="value">
                {{ $permohonan->nomor_surat_permohonan }} / 
                {{ $permohonan->tanggal_surat_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_surat_permohonan)->format('d M Y') : '-' }}
            </span>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- II. INFORMASI ALSINTAN -->
    <!-- ============================================ -->
    <div class="section">
        <div class="section-title">II. Informasi Alsintan yang akan Diuji</div>
        
        <div class="row-item">
            <span class="label">Jenis Alsintan<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->jenis_alsintan }}</span>
        </div>
        <div class="row-item">
            <span class="label">Status Alsintan<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->status_alsintan }}</span>
        </div>
        <div class="row-item">
            <span class="label">Status Produksi Alsintan<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->status_produksi }}</span>
        </div>
        <div class="row-item">
            <span class="label">Merek/Model/Tipe<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->merek_model_tipe }}</span>
        </div>
        <div class="row-item">
            <span class="label">Tahun Pembuatan<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->tahun_pembuatan ?? '-' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Jumlah Alsintan yang Diuji<span class="colon"> :</span></span>
            <span class="value">{{ $permohonan->jumlah_unit }} unit</span>
        </div>
        
        <!-- Spesifikasi Umum -->
        <div class="spec-title"><span class="number">1).</span> Motor Penggerak</div>
        <div class="sub-section">
            <div class="row-item">
                <span class="label">a. Daya maksimal (Hp/kW)<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->daya_maksimal ?? '-' }}</span>
            </div>
            <div class="row-item">
                <span class="label">b. Putaran Mesin (RPM)<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->putaran_mesin ?? '-' }}</span>
            </div>
            <div class="row-item">
                <span class="label">c. Bahan Bakar<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->bahan_bakar ?? '-' }}</span>
            </div>
            <div class="row-item">
                <span class="label">d. Sistem Pendinginan<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->sistem_pendinginan ?? '-' }}</span>
            </div>
        </div>
        
        <div class="spec-title" style="margin-top: 8px;"><span class="number">2).</span> Unit Alat</div>
        <div class="sub-section">
            <div class="row-item">
                <span class="label">a. Dimensi (p x l x t)<span class="colon"> :</span></span>
                <span class="value">
                    @php
                        $dimensiParts = [];
                        if ($permohonan->dimensi_p) $dimensiParts[] = $permohonan->dimensi_p;
                        if ($permohonan->dimensi_l) $dimensiParts[] = $permohonan->dimensi_l;
                        if ($permohonan->dimensi_t) $dimensiParts[] = $permohonan->dimensi_t;
                        echo !empty($dimensiParts) ? implode(' x ', $dimensiParts) : '-';
                    @endphp
                </span>
            </div>
            <div class="row-item">
                <span class="label">b. Berat (kg)<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->berat ?? '-' }}</span>
            </div>
            <div class="row-item">
                <span class="label">c. Kapasitas Kerja<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->kapasitas_kerja ?? '-' }}</span>
            </div>
            <div class="row-item">
                <span class="label">d. Perlengkapan<span class="colon"> :</span></span>
                <span class="value">{{ $permohonan->perlengkapan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- HALAMAN 2 - PAGE BREAK -->
    <!-- ================================================================ -->
    <div class="page-break">
        <!-- ============================================ -->
        <!-- KOP SURAT / HEADER -->
        <!-- ============================================ -->
        <div class="header" style="margin-top: -40px;">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="{{ public_path('images/logo-sumbar.png') }}" alt="">
                    </td>
                    <td class="header-text">
                        <div class="title-main">LABORATORIUM PENGUJI MUTU ALSINTAN</div>
                        <div class="title-sub">UPTD BALAI MEKANISASI DAN SARANA PRASARANA PERTANIAN</div>
                        <div class="title-instansi">DINAS PERKEBUNAN, TANAMAN PANGAN DAN HORTIKULTURA</div>
                        <div class="title-instansi">PROVINSI SUMATERA BARAT</div>
                        <div class="title-alamat">
                            Jln. Syech Djamil Djambek Landbouw Kota Bukittinggi, email : lpma.bmptph@gmail.com
                        </div>
                    </td>
                    <td class="header-right">
                        <img src="{{ public_path('images/logo-komite.png') }}" alt="">
                    </td>
                </tr>
            </table>
        </div>

        <!-- ============================================ -->
        <!-- III. DAFTAR PENGECEKAN PERSYARATAN -->
        <!-- ============================================ -->
        <div class="section">
            <div class="section-title">Daftar Pengecekan Persyaratan Permohonan Uji</div>
            
            <table class="table-checklist">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Uraian</th>
                        <th style="width: 130px; text-align: center;">Checklist</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $files = [
                            ['no' => 1, 'label' => 'Surat Permohonan Pengujian', 'field' => 'surat_permohonan'],
                            ['no' => 2, 'label' => 'Akte Pendirian Perusahaan dan perubahannya', 'field' => 'akte'],
                            ['no' => 3, 'label' => 'Kartu Tanda Penduduk (KTP)', 'field' => 'ktp'],
                            ['no' => 4, 'label' => 'Nomor Pokok Wajib Pajak (NPWP)', 'field' => 'npwp'],
                            ['no' => 5, 'label' => 'Surat Izin Usaha/Nomor Induk Berusaha (NIB)', 'field' => 'nib'],
                        ];
                        
                        // Tentukan persyaratan yang wajib berdasarkan status pemohon
                        $requiredFields = ['surat_permohonan'];
                        if ($permohonan->status_pemohon === 'UMKM') {
                            $requiredFields[] = 'ktp';
                        } elseif ($permohonan->status_pemohon === 'Produsen') {
                            $requiredFields = array_merge($requiredFields, ['ktp', 'akte', 'npwp', 'nib']);
                        }
                        // Pemerintah: hanya surat
                    @endphp
                    
                    @foreach($files as $file)
                        @php
                            $isUploaded = !empty($permohonan->{$file['field']});
                            $isRequired = in_array($file['field'], $requiredFields);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $file['no'] }}</td>
                            <td>
                                {{ $file['label'] }}
                                @if($isRequired)
                                    <span style="color: #e74c3c; font-size: 10px;">*</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($isUploaded)
                                    <span class="check-yes">Tersedia</span>
                                @elseif($isRequired)
                                    <span class="check-no">Belum</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Keterangan -->
            <div class="keterangan">
                <strong>Keterangan :</strong>
                <ul>
                    <li>
                        <span class="highlight">1.</span> Bengkel Pengrajin (UMKM) / Pembeli/Pengguna (perorangan) 
                        <span style="color: #1a6e4a; font-weight: 600;">:</span> Point 1 dan 3
                    </li>
                    <li>
                        <span class="highlight">2.</span> Pemerintah 
                        <span style="color: #1a6e4a; font-weight: 600;">:</span> Point 1
                    </li>
                    <li>
                        <span class="highlight">3.</span> Produsen/Distributor/Penyedia berbadan Hukum 
                        <span style="color: #1a6e4a; font-weight: 600;">:</span> Point 1, 2, 3, 4 dan 5
                    </li>
                </ul>
            </div>
        </div>

        <!-- TANDA TANGAN -->
        <table class="signature-table">
            <tr>
                <td class="col-left">
                    
                </td>
                <td class="col-right">
                    <div class="signature-box">
                        <span class="label-sign">Petugas Verifikasi Permohonan Uji</span>
                        
                        <!-- Ruang kosong untuk tanda tangan (60px) -->
                        <div class="sign-space"></div>
                        
                        <div class="sign-line">
                            ( ................................ )<br>
                            <span style="font-size: 10px; color: #666;">Tanda Tangan / Nama Jelas</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- <div class="footer-bottom">
            Dokumen ini dihasilkan secara otomatis dari sistem Permohonan Laboratorium UPTD BMSPP
        </div> --}}
    </div>

</body>
</html>