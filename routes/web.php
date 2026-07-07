<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\TestReportController;
use App\Http\Controllers\KuisionerController;
use Illuminate\Support\Facades\Route;

// Halaman utama (redirect ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pemohon', [DashboardController::class, 'pemohonDashboard'])->name('pemohon.dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Permohonan (pemohon)
    Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/permohonan/{id}/download/{type}', [PermohonanController::class, 'downloadFile'])->name('permohonan.download');

    // Validasi (admin)
    Route::get('/validasi/{permohonan_id}', [ValidasiController::class, 'show'])->name('validasi.show');
    Route::post('/validasi/{permohonan_id}', [ValidasiController::class, 'store'])->name('validasi.store');
    Route::get('/validasi/{permohonan_id}/download/{fileIndex?}', [ValidasiController::class, 'download'])->name('validasi.download');

    // Pengujian (admin)
    Route::get('/pengujian/{permohonan_id}', [PengujianController::class, 'show'])->name('pengujian.show');
    Route::post('/pengujian/{permohonan_id}', [PengujianController::class, 'store'])->name('pengujian.store');

    // Test Report (admin)
    Route::get('/test-report/{permohonan_id}', [TestReportController::class, 'show'])->name('testreport.show');
    Route::post('/test-report/{permohonan_id}', [TestReportController::class, 'store'])->name('testreport.store');
    Route::get('/test-report/{permohonan_id}/download/{fileIndex?}', [TestReportController::class, 'download'])->name('testreport.download');

    // Kuisioner (pemohon)
    Route::get('/kuisioner/{permohonan_id}', [KuisionerController::class, 'show'])->name('kuisioner.show');
    Route::post('/kuisioner/{permohonan_id}', [KuisionerController::class, 'store'])->name('kuisioner.store');
});