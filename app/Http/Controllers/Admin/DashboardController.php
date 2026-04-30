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

        $totalAnggota = User::where('role', '!=', 'admin')->count();

        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->count();

        $transaksiTerbaru = Peminjaman::with(['user', 'buku'])
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