<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KeinginanController;
use App\Http\Controllers\KeranjangController;

// publik
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/products/{slug}', [KatalogController::class, 'show'])->name('katalog.show');

Auth::routes();

Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

// pengguna (wajib wogin)
Route::middleware(['auth'])->group(function () {
    Route::get('/keinginan', [KeinginanController::class, 'index'])->name('keinginan.index');
    Route::post('/keinginan/toggle/{buku}', [KeinginanController::class, 'toggle'])->name('keinginan.toggle');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
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
        Route::resource('peminjaman', AdminPeminjamanController::class);
        Route::resource('pengembalian', AdminPengembalianController::class);

        // manajemen pengguna
        Route::resource('pengguna', UserController::class)->parameters(['pengguna' => 'user']);

        // laporan
        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/export', [ReportController::class, 'exportExcel'])->name('reports.export');
    });