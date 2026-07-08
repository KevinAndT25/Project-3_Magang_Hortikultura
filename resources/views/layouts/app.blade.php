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
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar.collapsed .sidebar-brand span,
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
        
        .sidebar.collapsed .sidebar-brand i {
            font-size: 24px;
            margin: 0;
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
            padding: 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        
        .sidebar-brand i {
            font-size: 28px;
            color: #27ae60;
            margin-right: 12px;
        }
        
        .sidebar-brand span {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }
        
        .sidebar-brand small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: rgba(255,255,255,0.5);
            margin-top: -2px;
        }
        
        /* Sidebar User Profile */
        .sidebar-user {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        
        .sidebar-user .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }
        
        .sidebar-user .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #fff;
            margin-bottom: 2px;
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
        
        /* Sidebar Menu */
        .sidebar-menu {
            padding: 15px 0;
            list-style: none;
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
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
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
                <i class="bi bi-flask"></i>
                <div>
                    <span>Lab Mutu Alsintan</span>
                    <small>UPTD BMSPP</small>
                </div>
            </div>
            
            <!-- User Profile -->
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="user-role">
                        <span class="role-badge">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ ucfirst(Auth::user()->role ?? 'Pemohon') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Menu -->
            <ul class="sidebar-menu">
                <li class="nav-item">
                    <a href="{{ $isAdmin ? route('dashboard.admin') : route('dashboard.pemohon') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!-- Menu Permohonan untuk semua user -->
                <li class="nav-item">
                    <a href="{{ route('permohonan.index') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Permohonan</span>
                    </a>
                </li>
                
                <!-- Menu khusus Pemohon: Permohonan Baru -->
                @if(!$isAdmin)
                <li class="nav-item">
                    <a href="{{ route('permohonan.create') }}" class="nav-link">
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
                    <button type="submit" class="logout-link w-100" style="background: none; border: none; text-align: left;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        
        // Toggle sidebar collapse (desktop)
        toggleBtn.addEventListener('click', function() {
            // Untuk mobile: toggle active class
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                
                // Update toggle button position
                if (sidebar.classList.contains('active')) {
                    toggleBtn.classList.add('shifted');
                } else {
                    toggleBtn.classList.remove('shifted');
                }
            } else {
                // Untuk desktop: toggle collapsed class
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
        
        // Active menu link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-menu .nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>