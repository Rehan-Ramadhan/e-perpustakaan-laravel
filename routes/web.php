<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// auth & google oauth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;

// public & user controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KeinginanController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;

// admin controllers
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalianController;
use App\Http\Controllers\Admin\laporanController;

// halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/products/{slug}', [KatalogController::class, 'show'])->name('katalog.show');

// auth routes
Auth::routes();
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

// halaman pengguna wajib login
Route::middleware(['auth'])->group(function () {

    // wishlist & keranjang
    Route::get('/keinginan', [KeinginanController::class, 'index'])->name('keinginan.index');
    Route::post('/keinginan/toggle/{buku}', [KeinginanController::class, 'toggle'])->name('keinginan.toggle');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // checkout & pesanan
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');

    // // manajemen profile
    // Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    // Route::patch('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

// halaman admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // crud utama
        Route::resource('buku', AdminBukuController::class);
        Route::resource('kategori', AdminKategoriController::class);

        Route::post('peminjaman/setujui/{id}', [AdminPeminjamanController::class, 'setujuiPesanan'])->name('peminjaman.setujui');
        Route::post('peminjaman/tolak/{id}', [AdminPeminjamanController::class, 'tolakPesanan'])->name('peminjaman.tolak');
        Route::resource('peminjaman', AdminPeminjamanController::class);

        Route::resource('pengembalian', AdminPengembalianController::class);

        // manajemen pengguna
        Route::resource('pengguna', UserController::class)->parameters(['pengguna' => 'user']);

        // laporan
        Route::get('/laporan', [laporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [laporanController::class, 'exportExcel'])->name('laporan.export');
    });