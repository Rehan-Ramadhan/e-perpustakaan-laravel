<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanPeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo = $request->date_to ?? now()->toDateString();

        $peminjamans = Peminjaman::with(['user'])
            ->whereDate('tanggal_pinjam', '>=', $dateFrom)
            ->whereDate('tanggal_pinjam', '<=', $dateTo)
            ->latest()
            ->paginate(15);

        $summary = DB::table('peminjamans')
            ->leftJoin('pengembalians', 'peminjamans.id', '=', 'pengembalians.peminjaman_id')
            ->whereDate('peminjamans.tanggal_pinjam', '>=', $dateFrom)
            ->whereDate('peminjamans.tanggal_pinjam', '<=', $dateTo)
            ->selectRaw('COUNT(peminjamans.id) as total_pinjam, SUM(pengembalians.denda) as total_denda')
            ->first();

        $byCategory = DB::table('peminjamans')
            ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
            ->select('bukus.lokasi_rak as kategori', DB::raw('COUNT(*) as total'))
            ->whereDate('peminjamans.tanggal_pinjam', '>=', $dateFrom)
            ->whereDate('peminjamans.tanggal_pinjam', '<=', $dateTo)
            ->groupBy('bukus.lokasi_rak')
            ->orderByDesc('total')
            ->get();

        return view('admin.laporan.index', compact(
            'peminjamans',
            'summary',
            'byCategory',
            'dateFrom',
            'dateTo'
        ));
    }

    public function exportExcel(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo = $request->date_to ?? now()->toDateString();

        return Excel::download(
            new LaporanPeminjamanExport($dateFrom, $dateTo),
            "laporan-perpus-{$dateFrom}-sd-{$dateTo}.xlsx"
        );
    }
}