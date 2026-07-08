@extends('layouts.app')

@section('title', 'Login Admin')
@section('container-class', 'auth-container full-width')

@section('content')
<style>
    .login-container {
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
    
    .login-card {
        width: 100%;
        max-width: 420px;
        background: white;
        border-radius: 12px;
        padding: 40px 35px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }
    
    .login-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .login-title h3 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
        font-size: 20px;
    }
    .login-title p {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 0;
    }
    
    .role-tabs {
        display: flex;
        background: #f0f2f5;
        border-radius: 8px;
        padding: 4px;
        margin-bottom: 25px;
    }
    .role-tab {
        flex: 1;
        text-align: center;
        padding: 10px 0;
        border-radius: 6px;
        font-weight: 500;
        font-size: 14px;
        color: #7f8c8d;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    .role-tab.active {
        background: white;
        color: #2c3e50;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .role-tab:hover {
        text-decoration: none;
        color: #2c3e50;
    }
    /* Warna berbeda untuk admin dan pemohon */
    .role-tab.admin-tab.active {
        color: #1a7a5a;
        border-left: 3px solid #1a7a5a;
    }
    .role-tab.pemohon-tab.active {
        color: #27ae60;
        border-left: 3px solid #27ae60;
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
    
    .btn-login {
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
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(39,174,96,0.4);
    }
    
    .login-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #7f8c8d;
    }
    .login-footer a {
        color: #27ae60;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .login-footer a:hover {
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
</style>

<div class="login-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-title">
            <h3>Lab Mutu Alsintan</h3>
            <p>UPTD BMSPP – Sistem Permohonan Pengujian Online</p>
        </div>

        <!-- Role Tabs -->
        <div class="role-tabs">
            <a href="{{ route('login.pemohon') }}" class="role-tab pemohon-tab">Login Pemohon</a>
            <a href="{{ route('login.admin') }}" class="role-tab admin-tab active">Login Admin</a>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" 
                       placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <!-- Footer --->
        <div class="login-footer">
            <span class="text-muted">Hanya untuk Admin</span>
        </div>
    </div>
</div>
@endsection