@extends('layouts.app')

@section('title', 'Lupa Password')
@section('container-class', 'auth-container full-width')

@section('content')
<style>
    .forgot-container {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1a7a5a 0%, #2ecc71 100%);
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(255,255,255,0.05) 0%, transparent 50%),
            linear-gradient(135deg, #1a7a5a 0%, #2ecc71 100%);
        padding: 20px;
        position: relative;
    }
    
    .forgot-card {
        width: 100%;
        max-width: 420px;
        background: white;
        border-radius: 12px;
        padding: 40px 35px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        position: relative;
        z-index: 1;
    }
    
    .forgot-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .forgot-title h3 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
        font-size: 20px;
    }
    .forgot-title p {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 0;
    }
    
    .forgot-title .back-link {
        display: inline-block;
        margin-top: 10px;
        color: #27ae60;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .forgot-title .back-link:hover {
        color: #1a7a5a;
        text-decoration: underline;
    }
    
    .forgot-title .icon-header {
        font-size: 48px;
        color: #27ae60;
        display: block;
        margin-bottom: 10px;
    }
    
    .form-label {
        font-weight: 500;
        font-size: 14px;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #e0e5ec;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control::placeholder {
        color: #b0b8c1;
        font-size: 13px;
    }
    
    .form-control:focus {
        border-color: #27ae60;
        box-shadow: 0 0 0 3px rgba(39,174,96,0.1);
    }
    
    .form-control.is-invalid {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231,76,60,0.1);
    }
    
    .form-text {
        font-size: 12px;
        color: #95a5a6;
        margin-top: 4px;
    }
    
    .form-text i {
        color: #27ae60;
    }
    
    .btn-submit {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        margin-top: 8px;
        transition: all 0.3s;
        cursor: pointer;
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(39,174,96,0.4);
    }
    
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .alert-custom {
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        border: none;
    }
    
    .alert-custom.alert-success {
        background: #d4edda;
        border: 1px solid #27ae60;
        color: #155724;
    }
    
    .alert-custom.alert-success i {
        color: #27ae60;
    }
    
    .alert-custom.alert-danger {
        background: #fce4ec;
        border: 1px solid #ef9a9a;
        color: #c62828;
    }
    
    .alert-custom.alert-danger i {
        color: #e74c3c;
    }
    
    .forgot-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #7f8c8d;
    }
    
    .forgot-footer a {
        color: #27ae60;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .forgot-footer a:hover {
        color: #1a7a5a;
        text-decoration: underline;
    }
    
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .btn-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
</style>

<div class="forgot-container">
    <div class="forgot-card">
        <!-- Header -->
        <div class="forgot-title">
            <i class="bi bi-key icon-header"></i>
            <h3>Lupa Password</h3>
            <p>Masukkan email Anda untuk mereset password</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-custom alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-custom alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-custom alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form Reset Password -->
        <form method="POST" action="{{ route('password.reset') }}" id="resetForm">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" 
                       placeholder="Masukkan email Anda"
                       value="{{ old('email') }}" required autofocus>
                <div class="form-text">
                    <i class="bi bi-info-circle"></i> 
                    Masukkan email yang terdaftar pada akun Anda.
                </div>
                @error('email')
                    <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn-submit" id="submitBtn">
                <span class="btn-content" id="btnContent">
                    <span id="btnText">Kirim Reset Password</span>
                    <span id="btnLoading" class="loading-spinner"></span>
                </span>
            </button>
        </form>

        <!-- Footer -->
        <div class="forgot-footer">
            <a href="{{ route('login.pemohon') }}">Kembali ke Login</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('resetForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');

        form.addEventListener('submit', function() {
            // Disable button dan tampilkan loading
            submitBtn.disabled = true;
            btnText.textContent = 'Mengirim...';
            btnLoading.style.display = 'inline-block';
        });

        // Auto-hide alert setelah 5 detik
        const alerts = document.querySelectorAll('.alert-custom');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            }, 5000);
        });
    });
</script>
@endsection