<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\TestReportController;
use App\Http\Controllers\KuisionerController;

// ======================
// HALAMAN UTAMA
// ======================
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }
        return redirect()->route('dashboard.pemohon');
    }
    return redirect()->route('login.pemohon');
});


// ======================
// LOGIN & REGISTER (TANPA AUTH)
// ======================
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::get('/login/pemohon', [AuthController::class, 'showLoginPemohon'])->name('login.pemohon');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// ROUTE YANG MEMBUTUHKAN AUTH (LOGIN)
// ======================
Route::middleware(['auth'])->group(function () {
    
    // --- ROUTE SHOW (BISA DIAKSES ADMIN & PEMOHON) ---
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/validasi/{permohonan_id}', [ValidasiController::class, 'show'])->name('validasi.show');
    Route::get('/pengujian/{permohonan_id}', [PengujianController::class, 'show'])->name('pengujian.show');
    Route::get('/testreport/{permohonan_id}', [TestReportController::class, 'show'])->name('testreport.show');
    Route::get('/kuisioner/{permohonan_id}', [KuisionerController::class, 'show'])->name('kuisioner.show');

    // --- ROUTE KHUSUS ADMIN ---
    Route::middleware(['auth', 'ensure.role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

        
        // Validasi
        Route::get('/validasi/create/{permohonan_id}', [ValidasiController::class, 'create'])->name('validasi.create');
        Route::post('/validasi/store/{permohonan_id}', [ValidasiController::class, 'store'])->name('validasi.store');
        
        // Pengujian
        Route::get('/pengujian/create/{permohonan_id}', [PengujianController::class, 'create'])->name('pengujian.create');
        Route::post('/pengujian/store/{permohonan_id}', [PengujianController::class, 'store'])->name('pengujian.store');
        
        // Test Report
        Route::get('/testreport/create/{permohonan_id}', [TestReportController::class, 'create'])->name('testreport.create');
        Route::post('/testreport/store/{permohonan_id}', [TestReportController::class, 'store'])->name('testreport.store');

        // Admin Users & Reports (tambahan untuk menu sidebar)
        Route::get('/users', function() {
            return view('admin.users');
        })->name('admin.users');
        
        Route::get('/reports', function() {
            return view('admin.reports');
        })->name('admin.reports');
    });

    // --- ROUTE KHUSUS PEMOHON ---
    Route::middleware(['auth', 'ensure.role:pemohon'])->group(function () {
        // Dashboard
        Route::get('/dashboard/pemohon', [DashboardController::class, 'pemohon'])->name('dashboard.pemohon');
        
        // Permohonan Baru
        Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
        Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');
        
        // Kuisioner
        Route::get('/kuisioner/create/{permohonan_id}', [KuisionerController::class, 'create'])->name('kuisioner.create');
        Route::post('/kuisioner/store/{permohonan_id}', [KuisionerController::class, 'store'])->name('kuisioner.store');
    });
});