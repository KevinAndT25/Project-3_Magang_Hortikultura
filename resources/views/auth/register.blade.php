@extends('layouts.app')

@section('title', 'Daftar Akun Pemohon')
@section('container-class', 'auth-container full-width')

@section('content')
<style>
    .register-container {
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
    
    .register-card {
        width: 100%;
        max-width: 480px;
        background: white;
        border-radius: 12px;
        padding: 40px 35px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        position: relative;
        z-index: 1;
    }
    
    .register-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .register-title h3 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
        font-size: 20px;
    }
    .register-title p {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 0;
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
        border-color: #f39c12;
        box-shadow: 0 0 0 3px rgba(243,156,18,0.1);
    }
    
    .btn-register {
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
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(39,174,96,0.4);
    }
    
    .register-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #7f8c8d;
    }
    .register-footer a {
        color: #27ae60;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .register-footer a:hover {
        color: #1a7a5a;
        text-decoration: underline;
    }
    
    .alert-custom {
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        border: none;
    }
    .alert-custom ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    /* Password Toggle Wrapper */
    .password-wrapper {
        position: relative;
    }
    .password-wrapper .form-control {
        padding-right: 45px;
    }
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #95a5a6;
        cursor: pointer;
        padding: 5px;
        font-size: 18px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .password-toggle:hover {
        color: #1a6e4a;
    }
    .password-toggle:focus {
        outline: none;
    }
    .password-toggle .bi {
        font-size: 20px;
    }
</style>

<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-title">
            <h3>Lab Mutu Alsintan</h3>
            <p>UPTD BMSPP – Sistem Permohonan Pengujian Online</p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="name" 
                       placeholder="Minimal 4 karakter" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" 
                       placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="email@domain.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Minimal 6 karakter" required>
                    <button type="button" class="password-toggle" id="togglePassword" 
                            title="Tampilkan/Sembunyikan password">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" id="password_confirmation" 
                        name="password_confirmation" placeholder="Masukkan ulang password" required>
                    <button type="button" class="password-toggle" id="togglePasswordconfirmation" 
                            title="Tampilkan/Sembunyikan password">
                        <i class="bi bi-eye-slash" id="toggleConfirmationIcon"></i>
                    </button>
                </div>
            </div> 
            <button type="submit" class="btn-register">Daftar Sekarang</button>
        </form>

        <!-- Footer -->
        <div class="register-footer">
            <a href="{{ route('login.pemohon') }}">Kembali ke Login</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordconfirmation = document.getElementById('togglePasswordconfirmation');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleConfirmationIcon = document.getElementById('toggleConfirmationIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle type input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon
            if (type === 'password') {
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                toggleIcon.className = 'bi bi-eye';
            }
        });

        togglePasswordconfirmation.addEventListener('click', function() {
            // Toggle type input
            const confirmationType = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationInput.setAttribute('type', confirmationType);

            // Toggle icon
            if (confirmationType === 'password_confirmation') {
                toggleConfirmationIcon.className = 'bi bi-eye-slash';
            } else {
                toggleConfirmationIcon.className = 'bi bi-eye';
            }
        });
    });
</script>
@endsection