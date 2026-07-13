<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kuisioner Kepuasan Pelanggan</title>
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
        
        /* ============================================
           SERVQUAL TABLE
           ============================================ */
        .servqual-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 12px;
        }
        .servqual-table th,
        .servqual-table td {
            border: 1px solid #ddd;
            padding: 6px 10px;
            text-align: left;
        }
        .servqual-table th {
            background: #f0f9f4;
            font-weight: 700;
            color: #1a6e4a;
        }
        .servqual-table .text-center {
            text-align: center;
        }
        
        /* Rating stars */
        .rating-text {
            font-weight: 600;
        }
        .rating-1 { color: #e74c3c; }
        .rating-2 { color: #e67e22; }
        .rating-3 { color: #f39c12; }
        .rating-4 { color: #2ecc71; }
        .rating-5 { color: #27ae60; }
        
        /* TANDA TANGAN */
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
           FOOTER
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
        <h1>KUISIONER KEPUASAN PELANGGAN</h1>
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
    <!-- I. PROFIL RESPONDEN -->
    <!-- ============================================ -->
    <div class="section">
        <div class="section-title">I. Profil Responden</div>
        
        <div class="row-item">
            <span class="label">Nama Responden<span class="colon"> :</span></span>
            <span class="value"><strong>{{ $kuisioner->nama_responden }}</strong></span>
        </div>
        <div class="row-item">
            <span class="label">No. Telepon Responden<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->telepon_responden }}</span>
        </div>
        <div class="row-item">
            <span class="label">Usia<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->usia }} tahun</span>
        </div>
        <div class="row-item">
            <span class="label">Jenis Kelamin<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Pendidikan Terakhir<span class="colon"> :</span></span>
            <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->pendidikan_terakhir)) }}</span>
        </div>
        <div class="row-item">
            <span class="label">Nama Perusahaan/Instansi<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->nama_perusahaan_instansi }}</span>
        </div>
        <div class="row-item">
            <span class="label">Alamat Perusahaan/Instansi<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->alamat_perusahaan }}</span>
        </div>
        <div class="row-item">
            <span class="label">Jabatan di Perusahaan<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->jabatan == 'pemilik_owner' ? 'Pemilik/Owner' : 'Staff' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Lama Bekerja<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->lama_bekerja_tahun }} tahun</span>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- II. INFORMASI UMUM -->
    <!-- ============================================ -->
    <div class="section">
        <div class="section-title">II. Informasi Umum Perihal Pengurusan Pengujian</div>
        
        <div class="row-item">
            <span class="label">Pengujian Pertama?<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->pengujian_pertama ? 'Ya' : 'Tidak' }}</span>
        </div>
        @if(!$kuisioner->pengujian_pertama)
        <div class="row-item">
            <span class="label">Pengujian ke-<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->pengujian_ke }}</span>
        </div>
        @endif
        <div class="row-item">
            <span class="label">Mewakili<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->mewakili == 'diri_sendiri' ? 'Diri Sendiri' : 'Perusahaan' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Terakhir Mengajukan<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->terakhir_mengajukan ?? '-' }}</span>
        </div>
        <div class="row-item">
            <span class="label">Unit Layanan<span class="colon"> :</span></span>
            <span class="value">{{ ucwords(str_replace('_', ' ', $kuisioner->unit_layanan)) }}</span>
        </div>
        <div class="row-item">
            <span class="label">Hari Laporan Keluar<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->hari_laporan_keluar }} hari</span>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- III. PENILAIAN SERVQUAL -->
    <!-- ============================================ -->
    <div class="section">
        <div class="section-title">III. Penilaian Servqual</div>
        
        <table class="servqual-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Pernyataan</th>
                    <th style="width: 120px; text-align: center;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $servqualData = [
                        ['no' => 1, 'label' => 'Pelayanan kepada konsumen', 'value' => $kuisioner->servqual_1],
                        ['no' => 2, 'label' => 'Keramahan personil', 'value' => $kuisioner->servqual_2],
                        ['no' => 3, 'label' => 'Ketepatan waktu pengujian', 'value' => $kuisioner->servqual_3],
                        ['no' => 4, 'label' => 'Kelengkapan alat', 'value' => $kuisioner->servqual_4],
                        ['no' => 5, 'label' => 'Ketepatan waktu penyerahan laporan uji', 'value' => $kuisioner->servqual_5],
                    ];
                    
                    $ratingLabels = [
                        1 => 'Sangat Buruk',
                        2 => 'Buruk',
                        3 => 'Cukup',
                        4 => 'Baik',
                        5 => 'Sangat Baik',
                    ];
                @endphp
                
                @foreach($servqualData as $item)
                <tr>
                    <td class="text-center">{{ $item['no'] }}</td>
                    <td>{{ $item['label'] }}</td>
                    <td class="text-center">
                        <span class="rating-text rating-{{ $item['value'] }}">
                            {{ $item['value'] }} - {{ $ratingLabels[$item['value']] ?? $item['value'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($kuisioner->kesan_pesan)
        <div class="row-item" style="margin-top: 10px;">
            <span class="label">Kesan Pesan<span class="colon"> :</span></span>
            <span class="value">{{ $kuisioner->kesan_pesan }}</span>
        </div>
        @endif
    </div>

    <div class="page-break">
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
        <!-- IV. KEPUASAN UMUM -->
        <!-- ============================================ -->
        <div class="section">
            <div class="section-title">IV. Kepuasan Secara Umum</div>
            
            @php
                $kepuasanLabels = [
                    'sangat_tidak_puas' => 'Sangat Tidak Puas',
                    'tidak_puas' => 'Tidak Puas',
                    'netral' => 'Netral',
                    'puas' => 'Puas',
                    'sangat_puas' => 'Sangat Puas',
                ];
                
                $rekomendasiLabels = [
                    'sangat_tidak' => 'Sangat Tidak Merekomendasikan',
                    'tidak' => 'Tidak Merekomendasikan',
                    'terserah' => 'Terserah',
                    'merekomendasikan' => 'Merekomendasikan',
                    'sangat_merekomendasikan' => 'Sangat Merekomendasikan',
                ];
            @endphp
            
            <div class="row-item">
                <span class="label">Tingkat Kepuasan<span class="colon"> :</span></span>
                <span class="value">{{ $kepuasanLabels[$kuisioner->kepuasan_umum] ?? $kuisioner->kepuasan_umum }}</span>
            </div>
            <div class="row-item">
                <span class="label">Rekomendasi<span class="colon"> :</span></span>
                <span class="value">{{ $rekomendasiLabels[$kuisioner->rekomendasi] ?? $kuisioner->rekomendasi }}</span>
            </div>
            @if($kuisioner->ide_saran)
            <div class="row-item">
                <span class="label">Ide & Saran<span class="colon"> :</span></span>
                <span class="value">{{ $kuisioner->ide_saran }}</span>
            </div>
            @endif
        </div>
        <!-- TANDA TANGAN -->
        <table class="signature-table">
            <tr>
                <td class="col-left">
                    
                </td>
                <td class="col-right">
                    <div class="signature-box">
                        <span class="label-sign">................., ......................</span>
                        
                        <!-- Ruang kosong untuk tanda tangan (60px) -->
                        <div class="sign-space"></div>
                        
                        <div class="sign-line">
                            ( ................................ )<br>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- <div class="footer-bottom">
        Dokumen ini dihasilkan secara otomatis dari sistem Permohonan Laboratorium UPTD BMSPP
    </div> --}} 

</body>
</html>