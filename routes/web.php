<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;

// Import Controllers
use App\Http\Controllers\Pengguna\BukuController as PenggunaBukuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;

// Publik
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/katalog', [PenggunaBukuController::class, 'index'])->name('pengguna.buku.index');
Route::get('/katalog/{slug}', [PenggunaBukuController::class, 'show'])->name('pengguna.buku.show');

// Auth Routes
Auth::routes();

// Pengguna (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/keinginan', [PenggunaBukuController::class, 'keinginan'])->name('pengguna.keinginan.index');
});

// Admin Area
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.') // Semua route di bawah ini diawali 'admin.'
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Resources
        Route::resource('buku', AdminBukuController::class);
        Route::resource('kategori', AdminKategoriController::class)->except(['show']);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);

        // Management User
        Route::get('user', [UserController::class, 'index'])->name('user.index');

        // Laporan
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');
    });