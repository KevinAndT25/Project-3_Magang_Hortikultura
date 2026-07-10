<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Permohonan Labor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Reset default */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body { 
            background: #f0f2f5; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* ============================================
           SIDEBAR STYLES
           ============================================ */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1a1a2e;
            color: #fff;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            overflow-y: auto;
            padding: 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar.collapsed .sidebar-brand span,
        .sidebar.collapsed .sidebar-brand small,
        .sidebar.collapsed .sidebar-brand .brand-text,
        .sidebar.collapsed .sidebar-menu span,
        .sidebar.collapsed .sidebar-user .user-info,
        .sidebar.collapsed .sidebar-user .user-role,
        .sidebar.collapsed .sidebar-logout span {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-brand {
            justify-content: center;
            padding: 15px 0;
        }
        
        .sidebar.collapsed .sidebar-brand .logo-container {
            margin-right: 0;
        }
        
        .sidebar.collapsed .sidebar-brand .logo-container img {
            width: 40px;
            height: 40px;
        }
        
        .sidebar.collapsed .sidebar-menu .nav-link {
            justify-content: center;
            padding: 12px;
        }
        
        .sidebar.collapsed .sidebar-menu .nav-link i {
            margin: 0;
            font-size: 20px;
        }
        
        .sidebar.collapsed .sidebar-user {
            padding: 10px;
            text-align: center;
        }
        
        .sidebar.collapsed .sidebar-user .user-avatar {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            font-size: 16px;
        }
        
        .sidebar.collapsed .sidebar-logout {
            justify-content: center;
            padding: 10px;
        }
        
        .sidebar.collapsed .sidebar-logout i {
            margin: 0;
            font-size: 20px;
        }
        
        /* Sidebar Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            padding: 20px 20px 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        
        .sidebar-brand .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .sidebar-brand .logo-container img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            padding: 4px;
        }
        
        .sidebar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .sidebar-brand .brand-text span {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }
        
        .sidebar-brand .brand-text small {
            font-size: 10px;
            font-weight: 400;
            color: rgba(255,255,255,0.5);
            margin-top: 1px;
            white-space: nowrap;
        }
        
        /* Sidebar User Profile */
        .sidebar-user {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .sidebar-user:hover {
            background: rgba(255,255,255,0.05);
        }
        
        .sidebar-user .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-user .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .sidebar-user .user-avatar .online-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: #27ae60;
            border-radius: 50%;
            border: 2px solid #1a1a2e;
        }
        
        .sidebar-user .user-avatar .edit-badge {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: #1a6e4a;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            border: 2px solid #1a1a2e;
        }
        
        .sidebar-user .user-info {
            flex: 1;
            min-width: 0;
        }
        
        .sidebar-user .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #fff;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar-user .user-role {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
        }
        
        .sidebar-user .user-role .role-badge {
            background: rgba(39,174,96,0.3);
            color: #27ae60;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .sidebar-user .user-arrow {
            color: rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            font-size: 12px;
        }
        
        .sidebar-user .user-arrow.open {
            transform: rotate(180deg);
        }
        
        /* User Profile Dropdown */
        .user-dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 0 0 50px;
        }
        
        .user-dropdown.open {
            max-height: 500px;
            padding: 10px 0 0 50px;
        }
        
        .user-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 6px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .user-dropdown .dropdown-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        
        .user-dropdown .dropdown-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: rgba(255,255,255,0.4);
        }
        
        .user-dropdown .dropdown-item.text-danger:hover {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        
        .user-dropdown .dropdown-item.text-danger:hover i {
            color: #e74c3c;
        }
        
        .user-dropdown .dropdown-divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 3px 0;
        }
        
        /* Sidebar Menu */
        .sidebar-menu {
            padding: 15px 0;
            list-style: none;
            flex: 1;
        }
        
        .sidebar-menu .nav-item {
            margin: 2px 10px;
        }
        
        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 8px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }
        
        .sidebar-menu .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }
        
        .sidebar-menu .nav-link.active {
            background: rgba(39,174,96,0.15);
            color: #27ae60;
        }
        
        .sidebar-menu .nav-link i {
            font-size: 18px;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-menu .nav-link span {
            white-space: nowrap;
        }
        
        /* Sidebar Logout */
        .sidebar-logout {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        
        .sidebar-logout .logout-link {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 8px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        
        .sidebar-logout .logout-link:hover {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        
        .sidebar-logout .logout-link i {
            font-size: 18px;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        
        /* ============================================
           MAIN CONTENT
           ============================================ */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: all 0.3s ease;
            padding: 20px;
        }
        
        .main-content.expanded {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
        
        /* Toggle Button */
        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            background: #1a1a2e;
            border: none;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-toggle:hover {
            background: #2d2d44;
        }
        
        .sidebar-toggle.shifted {
            left: 85px;
        }
        
        /* Container untuk auth pages */
        .auth-container {
            width: 100%;
            min-height: 100vh;
            padding: 0;
            margin: 0;
            max-width: 100% !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .full-width {
            width: 100%;
            padding: 0;
            margin: 0;
        }
        
        /* Background hijau untuk auth */
        .auth-bg {
            background: linear-gradient(135deg, #1a6e4a 0%, #2ecc71 100%);
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(255,255,255,0.05) 0%, transparent 50%),
                linear-gradient(135deg, #1a6e4a 0%, #2ecc71 100%);
        }
        
        /* Card styling */
        .card { 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        
        /* Alert styling */
        .alert {
            border-radius: 8px;
        }
        
        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .modal-header {
            border-bottom: 1px solid #f0f2f5;
            padding: 20px 25px;
        }
        .modal-header .modal-title {
            font-weight: 700;
            color: #2c3e50;
        }
        .modal-body {
            padding: 25px;
        }
        .modal-footer {
            border-top: 1px solid #f0f2f5;
            padding: 15px 25px;
        }
        .modal .form-control {
            border-radius: 8px;
            border: 1px solid #dce1e8;
            padding: 10px 14px;
        }
        .modal .form-control:focus {
            border-color: #1a6e4a;
            box-shadow: 0 0 0 3px rgba(26, 110, 74, 0.1);
        }
        .modal .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #2c3e50;
        }
        .modal .btn-primary {
            background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
        }
        .modal .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(26, 110, 74, 0.4);
        }
        .modal .btn-secondary {
            background: #f0f2f5;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            color: #7f8c8d;
        }
        .modal .btn-secondary:hover {
            background: #e0e5ec;
            color: #2c3e50;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
                width: 260px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .sidebar.collapsed {
                margin-left: -260px;
                width: 260px;
            }
            
            .sidebar.collapsed.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .main-content.expanded {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar-toggle {
                display: flex;
            }
            
            /* Overlay */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 998;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
            
            .user-dropdown {
                padding: 0 0 0 20px;
            }
            
            .user-dropdown.open {
                padding: 10px 0 10px 20px;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar-toggle {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

@php
    $isAuthPage = in_array(Route::currentRouteName(), ['login.admin', 'login.pemohon', 'register']);
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
@endphp

@if($isAuthPage)
    <!-- Tampilan Auth (Login/Register) tanpa sidebar -->
    <div class="auth-container @yield('container-class', '')">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert" style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert" style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
@else
    <!-- Tampilan Dashboard dengan Sidebar -->
    <div class="wrapper">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <!-- Brand -->
            <div class="sidebar-brand">
                <div class="logo-container">
                    <img src="{{ asset('images/logo-sumbar.png') }}" alt="Logo Sumbar" id="sidebarLogo">
                </div>
                <div class="brand-text">
                    <span>Lab Mutu Alsintan</span>
                    <small>UPTD BMSPP Prov. Sumatera Barat</small>
                </div>
            </div>
            
            <!-- User Profile -->
            <div class="sidebar-user" id="userProfileToggle">
                <div class="user-profile">
                    <div class="user-avatar" style="background: {{ $user->avatar_color ?? '#1a6e4a' }}">
                        {{ $user->initials ?? strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        <span class="online-dot"></span>
                        <span class="edit-badge">
                            <i class="bi bi-pencil" style="font-size: 8px;"></i>
                        </span>
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $user->name ?? 'User' }}</div>
                        <div class="user-role">
                            <span class="role-badge">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ ucfirst($user->role ?? 'Pemohon') }}
                            </span>
                        </div>
                    </div>
                    <i class="bi bi-chevron-down user-arrow" id="userArrow"></i>
                </div>
                
                <!-- Dropdown - SEMUA USER BISA KELOLA AKUN -->
                <div class="user-dropdown" id="userDropdown">
                    <button class="dropdown-item" onclick="openProfileModal()">
                        <i class="bi bi-person-gear"></i>
                        <span>Kelola Akun</span>
                    </button>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Menu -->
            <ul class="sidebar-menu">
                <li class="nav-item">
                    <a href="{{ $isAdmin ? route('dashboard.admin') : route('dashboard.pemohon') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!-- Menu Permohonan untuk semua user -->
                <li class="nav-item">
                    <a href="{{ route('permohonan.index') }}" class="nav-link {{ request()->routeIs('permohonan.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Daftar Permohonan</span>
                    </a>
                </li>
                
                <!-- Menu khusus Pemohon: Permohonan Baru -->
                @if(!$isAdmin)
                <li class="nav-item">
                    <a href="{{ route('permohonan.create') }}" class="nav-link {{ request()->routeIs('permohonan.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Permohonan Baru</span>
                    </a>
                </li>
                @endif
            </ul>
            
            <!-- Logout -->
            <div class="sidebar-logout">
                <form action="{{ route('logout') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="logout-link w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </nav>
        
        <!-- Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
@endif

<!-- ============================================ -->
<!-- MODAL KELOLA AKUN (UNTUK SEMUA USER) -->
<!-- ============================================ -->
@auth
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="bi bi-person-gear me-2" style="color: #1a6e4a;"></i>
                        Kelola Akun
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profile_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="profile_name" name="name" 
                               value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="profile_email" name="email" 
                               value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_no_hp" class="form-label">Nomor Handphone</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                               id="profile_no_hp" name="no_hp" 
                               value="{{ old('no_hp', Auth::user()->no_hp ?? '') }}" placeholder="08xxxxxxxxx">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    <p class="text-muted" style="font-size: 13px;">Kosongkan kolom password jika tidak ingin mengubah password.</p>
                    <div class="mb-3">
                        <label for="profile_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="profile_password" name="password" 
                               placeholder="Minimal 6 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" 
                               id="profile_password_confirmation" 
                               name="password_confirmation" placeholder="Ketik ulang password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        
        // Toggle sidebar collapse (desktop)
        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                
                if (sidebar.classList.contains('active')) {
                    toggleBtn.classList.add('shifted');
                } else {
                    toggleBtn.classList.remove('shifted');
                }
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });
        
        // Close sidebar on overlay click (mobile)
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            toggleBtn.classList.remove('shifted');
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                toggleBtn.classList.remove('shifted');
            }
        });
        
        // ============================================
        // USER PROFILE DROPDOWN TOGGLE
        // ============================================
        const userProfileToggle = document.getElementById('userProfileToggle');
        const userDropdown = document.getElementById('userDropdown');
        const userArrow = document.getElementById('userArrow');
        
        if (userProfileToggle) {
            userProfileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('open');
                userArrow.classList.toggle('open');
            });
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (userDropdown && userProfileToggle) {
                if (!userProfileToggle.contains(e.target)) {
                    userDropdown.classList.remove('open');
                    userArrow.classList.remove('open');
                }
            }
        });
        
        // ============================================
        // ACTIVE MENU LINK
        // ============================================
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-menu .nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
    
    // ============================================
    // MODAL FUNCTIONS (UNTUK SEMUA USER)
    // ============================================
    function openProfileModal() {
        const modal = new bootstrap.Modal(document.getElementById('profileModal'));
        modal.show();
    }
</script>
@stack('scripts')
</body>
</html> 