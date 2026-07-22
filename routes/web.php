<?php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\PermohonanController;
    use App\Http\Controllers\ValidasiController;
    use App\Http\Controllers\PengujianController;
    use App\Http\Controllers\TestReportController;
    use App\Http\Controllers\KuisionerController;
    use App\Http\Controllers\FileController;
    use App\Http\Controllers\PermohonanPdfController; 
    use App\Http\Controllers\KuisionerPdfController;

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
    // LOGIN & REGISTER
    // ======================
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
    Route::get('/login/pemohon', [AuthController::class, 'showLoginPemohon'])->name('login.pemohon');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logoutGet'])->name('logout.get');

    // ======================
    // ROUTE DENGAN AUTH
    // ======================
    Route::middleware(['auth'])->group(function () {
        // Route untuk update profil
        Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

        // Show routes
        Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
        Route::get('/validasi/{permohonan_id}', [ValidasiController::class, 'show'])->name('validasi.show');
        Route::get('/pengujian/{permohonan_id}', [PengujianController::class, 'show'])->name('pengujian.show');
        Route::get('/testreport/{permohonan_id}', [TestReportController::class, 'show'])->name('testreport.show');
        Route::get('/kuisioner/{permohonan_id}', [KuisionerController::class, 'show'])->name('kuisioner.show');

        // Route untuk melihat file
        Route::get('/file/{path}', [FileController::class, 'show'])
            ->name('file.show')
            ->where('path', '.*');
            
        // Route download pdf
        Route::get('/permohonan/{id}/pdf', [PermohonanPdfController::class, 'download'])
            ->name('permohonan.pdf')
            ->middleware('auth');
        Route::get('/kuisioner/{permohonan_id}/pdf', [KuisionerPdfController::class, 'download'])
            ->name('kuisioner.pdf')
            ->middleware('auth');

        // ============================================
        // ROUTE ADMIN
        // ============================================
        Route::prefix('admin')->middleware(['auth', 'ensure.role:admin'])->group(function () {
            Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
            
            // Hapus permohonan aktif
            Route::delete('/permohonan/{id}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');

            // Validasi
            Route::get('/validasi/create/{permohonan_id}', [ValidasiController::class, 'create'])->name('validasi.create');
            Route::post('/validasi/store/{permohonan_id}', [ValidasiController::class, 'store'])->name('validasi.store');
            
            // Pengujian
            Route::get('/pengujian/create/{permohonan_id}', [PengujianController::class, 'create'])->name('pengujian.create');
            Route::post('/pengujian/store/{permohonan_id}', [PengujianController::class, 'store'])->name('pengujian.store');
            
            // Test Report
            Route::get('/testreport/create/{permohonan_id}', [TestReportController::class, 'create'])->name('testreport.create');
            Route::post('/testreport/store/{permohonan_id}', [TestReportController::class, 'store'])->name('testreport.store');

            // Admin Users & Reports
            Route::get('/users', [UserController::class, 'index'])->name('admin.users');
            Route::get('/reports', function() { return view('admin.reports'); })->name('admin.reports');
        });

        // ============================================
        // ROUTE PEMOHON
        // ============================================
        Route::prefix('user')->middleware(['auth', 'ensure.role:pemohon'])->group(function () {
            Route::get('/dashboard/pemohon', [DashboardController::class, 'pemohon'])->name('dashboard.pemohon');
            
            // Permohonan Create
            Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
            Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');
            
            // Edit Draft
            Route::get('/permohonan/{id}/edit', [PermohonanController::class, 'edit'])->name('permohonan.edit');
            Route::put('/permohonan/{id}', [PermohonanController::class, 'update'])->name('permohonan.update');
            Route::post('/permohonan/{id}/submit', [PermohonanController::class, 'submitDraft'])->name('permohonan.submit');

            // Hapus Draft
            Route::delete('/permohonan/{id}', [PermohonanController::class, 'destroy'])->name('draft.destroy');

            // Pengujian Approve & Reject
            Route::post('/pengujian/{permohonan_id}/approve', [PengujianController::class, 'approve'])->name('pengujian.approve');
            Route::post('/pengujian/{permohonan_id}/reject', [PengujianController::class, 'reject'])->name('pengujian.reject');
            
            // Kuisioner
            Route::get('/kuisioner/create/{permohonan_id}', [KuisionerController::class, 'create'])->name('kuisioner.create');
            Route::post('/kuisioner/store/{permohonan_id}', [KuisionerController::class, 'store'])->name('kuisioner.store');
        });
    });