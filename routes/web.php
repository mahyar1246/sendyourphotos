<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahan untuk fungsi Auth
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\HomeController;



// --- Sistem Autentikasi (Bebas Diakses) ---

// 1. Menampilkan halaman desain UI Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// 2. Memproses data saat tombol "Sign In" ditekan
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

// --- Rute untuk Register ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.post');


// =========================================================================
// --- AREA TERLINDUNG (WAJIB LOGIN) ---
// Semua rute di dalam kotak ini akan otomatis dilempar ke form Login jika belum masuk
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    // Rute Logout (BARU DITAMBAHKAN)
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // Rute Halaman Utama & Detail Foto (Sekarang digembok!)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/photo/{id}', [HomeController::class, 'show'])->name('photo.show');

    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Pencairan Dana
    Route::post('/withdraw', [App\Http\Controllers\DashboardController::class, 'withdraw'])->name('withdraw');
    
    // Rute Upload Foto
    Route::get('/upload', [PhotoController::class, 'create'])->name('upload');
    Route::post('/upload', [PhotoController::class, 'store'])->name('upload.post');

    // Rute Edit Foto
    Route::get('/photo/{id}/edit', [PhotoController::class, 'edit'])->name('photo.edit');
    Route::put('/photo/{id}', [PhotoController::class, 'update'])->name('photo.update');
    
    // Rute untuk Halaman Checkout (Sudah dirapikan, tidak double lagi)
    Route::get('/checkout/{id}', [App\Http\Controllers\TransactionController::class, 'checkout'])->name('checkout');
    
    // Rute untuk Memproses Pembayaran
    Route::post('/checkout/{id}/process', [App\Http\Controllers\TransactionController::class, 'process'])->name('checkout.process');

    // Rute untuk melihat kurva pendapatan
    Route::get('/earnings', [App\Http\Controllers\DashboardController::class, 'earnings'])->name('earnings.index');

    Route::post('/upgrade-acc', [App\Http\Controllers\DashboardController::class, 'upgradeToContributor'])->name('upgrade.account');
    Route::post('/wishlist/{photo_id}', [App\Http\Controllers\DashboardController::class, 'toggleWishlist'])->name('wishlist.toggle');
    
    // Route untuk melihat profil publik kreator
    Route::get('/creator/{id}', [App\Http\Controllers\HomeController::class, 'creatorProfile'])->name('creator.profile');

    // Route untuk menghapus foto
    Route::delete('/photo/{id}', [App\Http\Controllers\PhotoController::class, 'destroy'])->name('photo.delete');

    // Route untuk mengganti tema (Autumn/Forest/Ocean)
    Route::get('/set-theme/{theme}', function($theme) {
        if (in_array($theme, ['autumn', 'forest', 'ocean'])) {
            session(['user_theme' => $theme]);
        }
        return back();
    })->name('set.theme');

    // Route untuk halaman Syarat & Ketentuan Upgrade
    Route::get('/upgrade-account/terms', [App\Http\Controllers\DashboardController::class, 'upgradeTerms'])->name('upgrade.terms');

    // Route untuk memproses perubahan role
    Route::post('/upgrade-account/process', [App\Http\Controllers\DashboardController::class, 'processUpgrade'])->name('upgrade.process');
    
    // Rute di dalam group middleware auth
Route::get('/upgrade-persyaratan', [DashboardController::class, 'showUpgradeTerms'])->name('upgrade.terms');
Route::post('/upgrade-eksekusi', [DashboardController::class, 'processUpgrade'])->name('upgrade.process');

});


// Fitur Lupa Password (Bypass / Langsung)
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'showDirectReset'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'processDirectReset'])->name('password.update.direct');