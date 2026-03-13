<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// pengguna
use App\Http\Controllers\Pengguna\BukuController as PenggunaBukuController;

// admin
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\DashboardController;

// publik
Route::get('/', function () {
    return redirect()->route('pengguna.buku.index');
});

Route::get('/katalog', [PenggunaBukuController::class, 'index'])->name('pengguna.buku.index');
Route::get('/katalog/{slug}', [PenggunaBukuController::class, 'show'])->name('pengguna.buku.show');


// auth routes (login, register, logout)
Auth::routes();


// pengguna (wajib login)
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

        // manajemen buku (CRUD)
        Route::resource('bukus', AdminBukuController::class);

        // manajemen kategori (CRUD)
        Route::resource('kategoris', AdminKategoriController::class)->except(['show']);

        // manajemen pengguna (CRUD)
        // Route::get('/users', [UserController::class, 'index])->name('users.index');
    });