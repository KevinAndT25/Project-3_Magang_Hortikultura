<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\TestReportController;
use App\Http\Controllers\KuisionerController;
use Illuminate\Support\Facades\Route;

// Halaman utama - redirect ke login
Route::get('/', function () {
    return redirect('/login/pemohon');
});

// Auth routes
// Login & Register
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::get('/login/pemohon', [AuthController::class, 'showLoginPemohon'])->name('login.pemohon');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
// Dashboard
Route::middleware(['auth'])->group(function () {
    // Route SHOW - bisa diakses oleh admin dan pemohon (dengan pengecekan di controller)
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/validasi/{permohonan_id}', [ValidasiController::class, 'show'])->name('validasi.show');
    Route::get('/pengujian/{permohonan_id}', [PengujianController::class, 'show'])->name('pengujian.show');
    Route::get('/testreport/{permohonan_id}', [TestReportController::class, 'show'])->name('testreport.show');
    Route::get('/kuisioner/{permohonan_id}', [KuisionerController::class, 'show'])->name('kuisioner.show');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/validasi/create/{permohonan_id}', [ValidasiController::class, 'create'])->name('validasi.create');
        Route::post('/validasi/store/{permohonan_id}', [ValidasiController::class, 'store'])->name('validasi.store');
        Route::get('/pengujian/create/{permohonan_id}', [PengujianController::class, 'create'])->name('pengujian.create');
        Route::post('/pengujian/store/{permohonan_id}', [PengujianController::class, 'store'])->name('pengujian.store');
        Route::get('/testreport/create/{permohonan_id}', [TestReportController::class, 'create'])->name('testreport.create');
        Route::post('/testreport/store/{permohonan_id}', [TestReportController::class, 'store'])->name('testreport.store');
    });

    Route::middleware(['role:pemohon'])->group(function () {
        Route::get('/dashboard/pemohon', [DashboardController::class, 'pemohon'])->name('dashboard.pemohon');
        Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
        Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');
        Route::get('/kuisioner/create/{permohonan_id}', [KuisionerController::class, 'create'])->name('kuisioner.create');
        Route::post('/kuisioner/store/{permohonan_id}', [KuisionerController::class, 'store'])->name('kuisioner.store');
    });
    
});