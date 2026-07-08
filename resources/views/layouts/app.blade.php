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
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Navbar styling */
        .navbar {
            z-index: 1000;
        }
        
        /* Container default untuk halaman biasa */
        .container {
            max-width: 900px;
            margin-top: 50px;
        }
        
        /* Container untuk halaman auth (login/register) - full screen */
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
        
        /* Hilangkan margin top untuk auth pages */
        .auth-container {
            margin-top: 0 !important;
        }
        
        .card { 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        
        .btn-primary { 
            background: #0d6efd; 
            border: none; 
        }
        .btn-primary:hover { 
            background: #0b5ed7; 
        }
        
        /* Alert styling */
        .alert {
            border-radius: 8px;
        }
        
        /* Untuk halaman non-auth, tetap tampilkan navbar dan container biasa */
        .main-wrapper {
            min-height: calc(100vh - 56px);
            padding: 20px 0;
        }
        
        /* Full width untuk auth pages */
        .full-width {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        /* Background hijau yang lebih tua untuk semua halaman auth */
        .auth-bg {
            background: linear-gradient(135deg, #1a6e4a 0%, #2ecc71 100%);
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(255,255,255,0.05) 0%, transparent 50%),
                linear-gradient(135deg, #1a6e4a 0%, #2ecc71 100%);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">PermohonanLabor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-white">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.pemohon') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="@yield('container-class', 'container')">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sembunyikan navbar di halaman auth
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const authPages = ['/login/admin', '/login/pemohon', '/register'];
            
            if (authPages.includes(currentPath)) {
                const navbar = document.getElementById('mainNavbar');
                if (navbar) {
                    navbar.style.display = 'none';
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>