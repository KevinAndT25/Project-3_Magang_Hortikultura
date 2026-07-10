<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .body {
            padding: 30px;
        }
        .body h2 {
            color: #1a6e4a;
            font-size: 18px;
            margin-top: 0;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 12px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin: 15px 0 20px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 10px 14px;
            border-radius: 8px;
            border-left: 3px solid #1a6e4a;
        }
        .info-item .label {
            font-size: 11px;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
        }
        .info-item .value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
            margin-top: 2px;
            display: block;
        }
        .divider {
            border: none;
            border-top: 1px solid #f0f2f5;
            margin: 20px 0;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 110, 74, 0.3);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #f0f2f5;
        }
        .footer a {
            color: #1a6e4a;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .status-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 20px;
            }
            .body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📋 Permohonan Pengujian Baru</h1>
            <p>Laboratorium Penguji Mutu Alsintan UPTD BMSPP</p>
        </div>

        <!-- Body -->
        <div class="body">
            <h2>Detail Permohonan</h2>
            <p style="color: #7f8c8d; margin-bottom: 15px;">
                Seorang pemohon telah mengajukan permohonan pengujian baru. Silakan segera lakukan validasi.
            </p>

            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nomor Permohonan</span>
                    <span class="value">{{ $permohonan->no_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Tanggal Permohonan</span>
                    <span class="value">{{ $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('d M Y, H:i') : '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Nama Pemohon</span>
                    <span class="value">{{ $permohonan->nama_pemohon ?? 'Unknown' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Status Pemohon</span>
                    <span class="value">{{ $permohonan->status_pemohon ?? 'Pemohon' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Jenis Alsintan</span>
                    <span class="value">{{ $permohonan->jenis_alsintan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Merek/Model/Tipe</span>
                    <span class="value">{{ $permohonan->merek_model_tipe ?? '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="label">Perusahaan/Instansi</span>
                    <span class="value">{{ $permohonan->perusahaan_instansi ?? '-' }}</span>
                </div>
            </div>

            <hr class="divider">

            <div style="text-align: center; margin: 25px 0 10px;">
                <span class="status-badge">🔄 Menunggu Validasi</span>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('validasi.create', $permohonan->id) }}" class="action-button">
                    🚀 Lakukan Validasi Sekarang
                </a>
            </div>
            <p style="text-align: center; color: #95a5a6; font-size: 12px; margin-top: 10px;">
                Atau akses dashboard admin untuk melihat semua permohonan.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>UPTD BMSPP Provinsi Sumatera Barat</strong><br>
                Laboratorium Penguji Mutu Alsintan<br>
                <small>Email ini dikirim secara otomatis oleh sistem.</small>
            </p>
            <p style="margin-top: 8px;">
                <a href="{{ route('dashboard.admin') }}">Dashboard Admin</a> &bull;
                <a href="#">Bantuan</a>
            </p>
        </div>
    </div>
</body>
</html>