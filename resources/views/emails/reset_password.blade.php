<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7fa; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%); padding: 25px 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; font-weight: 700; }
        .header .sub { color: rgba(255,255,255,0.8); font-size: 14px; margin-top: 5px; }
        .body { padding: 30px; }
        .body p { color: #333; line-height: 1.6; margin: 0 0 12px 0; }
        .body .highlight { background: #f0f9f4; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #1a6e4a; margin: 15px 0; }
        .body .highlight strong { color: #1a6e4a; }
        .body .password-box { background: #fff3cd; padding: 12px 20px; border-radius: 8px; border: 1px solid #ffc107; text-align: center; margin: 15px 0; }
        .body .password-box .password-text { font-size: 20px; font-weight: 700; color: #1a6e4a; letter-spacing: 2px; }
        .btn { display: inline-block; background: #1a6e4a; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 15px; }
        .btn:hover { background: #155d3e; }
        .footer { padding: 20px 30px; background: #f8f9fa; text-align: center; font-size: 13px; color: #95a5a6; border-top: 1px solid #eee; }
        .footer a { color: #1a6e4a; text-decoration: none; }
        .warning { color: #e74c3c; font-size: 12px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔑 Reset Password</h1>
            <div class="sub">Laboratorium Penguji Mutu Alsintan UPTD BMSPP</div>
        </div>
        <div class="body">
            <p>Yth. <strong>{{ $user->name }}</strong>,</p>
            <p>Kami menerima permintaan reset password untuk akun Anda di sistem <strong>Lab Mutu Alsintan</strong>.</p>
            
            <div class="highlight">
                <p style="margin: 0; font-size: 14px;">
                    Berikut adalah <strong>password baru</strong> untuk akun Anda:
                </p>
            </div>
            
            <div class="password-box">
                <span class="password-text">{{ $newPassword }}</span>
            </div>
            
            <p style="font-size: 14px;">
                <strong>⚠️ Penting:</strong> 
                Setelah login, segera ubah password Anda di menu <strong>"Kelola Akun"</strong> untuk keamanan.
            </p>
            
            <a href="{{ route('login.pemohon') }}" class="btn">Login ke Sistem</a>
            
            <p class="warning">
                <i class="bi bi-info-circle"></i> 
                Jika Anda tidak meminta reset password, abaikan email ini.
            </p>
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