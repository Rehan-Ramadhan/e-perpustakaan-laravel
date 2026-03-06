<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pengguna;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('stok');
        $totalAnggota = Pengguna::count();
        $sedangDipinjam = Peminjaman::where('status', 'pinjam')->count();

        $terlambat = Peminjaman::where('status', 'pinjam')
            ->where('tgl_harus_kembali', '<', Carbon::now())
            ->count();

        $transaksiTerbaru = Peminjaman::with('pengguna')
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