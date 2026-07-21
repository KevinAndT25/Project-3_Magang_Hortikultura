<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengujian Diterima</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%); padding: 25px 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; font-weight: 700; }
        .header .sub { color: rgba(255,255,255,0.8); font-size: 14px; margin-top: 5px; }
        .body { padding: 30px; }
        .body p { color: #333; line-height: 1.6; margin: 0 0 12px 0; }
        .body .highlight { background: #f0f9f4; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #27ae60; margin: 15px 0; }
        .body .highlight strong { color: #27ae60; }
        .body .status-badge { display: inline-block; background: #27ae60; color: white; padding: 4px 16px; border-radius: 20px; font-weight: 600; font-size: 14px; }
        .btn { display: inline-block; background: #27ae60; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 15px; }
        .btn:hover { background: #1a7a4a; }
        .footer { padding: 20px 30px; background: #f8f9fa; text-align: center; font-size: 13px; color: #95a5a6; border-top: 1px solid #eee; }
        .footer a { color: #27ae60; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Pengujian Diterima</h1>
            <div class="sub">Laboratorium Penguji Mutu Alsintan UPTD BMSPP</div>
        </div>
        <div class="body">
            <p>Yth. <strong>Admin</strong>,</p>
            
            <div class="highlight">
                <p style="margin: 0; font-size: 15px;">
                    Pemohon <strong>{{ $pemohon->name ?? 'Pemohon' }}</strong> 
                    telah <strong>menyetujui</strong> hasil pengujian untuk permohonan:
                </p>
                <p style="margin: 8px 0 0 0; font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
                <p style="margin: 5px 0 0 0; font-size: 14px;">
                    <strong>Jenis Alsintan:</strong> {{ $permohonan->jenis_alsintan }}
                </p>
                <p style="margin: 5px 0 0 0; font-size: 14px;">
                    <strong>Tanggal Persetujuan:</strong> {{ now()->format('d M Y H:i') }}
                </p>
            </div>
            
            <div style="text-align: center; margin: 15px 0;">
                <span class="status-badge">
                    <i class="bi bi-check-circle"></i> DISETUJUI
                </span>
            </div>
            
            <p>
                <strong>Status:</strong> Permohonan telah disetujui oleh pemohon dan dapat melanjutkan ke tahap 
                <strong>Test Report</strong>.
            </p>
            
            <p>Silakan login ke sistem untuk mengisi Test Report pada permohonan ini.</p>
            
            <a href="{{ route('login.admin') }}" class="btn">Login ke Sistem</a>
        </div>
        <div class="footer">
            <p style="margin: 0;">
                © {{ date('Y') }} Lab Mutu Alsintan UPTD BMSPP<br>
                <small>Email ini dikirim secara otomatis oleh sistem.</small>
            </p>
        </div>
    </div>
</body>
</html>