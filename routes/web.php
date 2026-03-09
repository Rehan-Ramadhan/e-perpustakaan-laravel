<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('admin')->group(function () {

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('buku', BukuController::class);
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);

        Route::get('/admin/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/admin/reports/export', [ReportController::class, 'exportExcel'])->name('reports.export');
    });
});