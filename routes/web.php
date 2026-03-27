<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Pengguna\BukuController as PenggunaBukuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\ReportController;

// publik
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/katalog', [PenggunaBukuController::class, 'index'])->name('pengguna.buku.index');
Route::get('/katalog/{slug}', [PenggunaBukuController::class, 'show'])->name('pengguna.buku.show');

Auth::routes();

// pengguna (wajib wogin)
Route::middleware(['auth'])->group(function () {
    Route::get('/keinginan', [PenggunaBukuController::class, 'keinginan'])->name('pengguna.keinginan.index');
});

// admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // crud resources
        Route::resource('buku', AdminBukuController::class);
        Route::resource('kategori', AdminKategoriController::class)->except(['show']);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);

        // manajemen pengguna
        Route::resource('pengguna', UserController::class)->parameters(['pengguna' => 'user']);

        // laporan
        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/export', [ReportController::class, 'exportExcel'])->name('reports.export');
    });