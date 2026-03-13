<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('stok');
        $totalAnggota = User::count();
        $sedangDipinjam = Peminjaman::where('status', 'pinjam')->count();

        $terlambat = Peminjaman::where('status', 'pinjam')
            ->where('tanggal_jatuh_tempo', '<', Carbon::now())
            ->count();

        $transaksiTerbaru = Peminjaman::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'sedangDipinjam',
            'terlambat',
            'transaksiTerbaru'
        ));
    }
}