<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanPeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo = $request->date_to ?? now()->toDateString();

        $peminjamans = Peminjaman::with(['pengguna', 'peminjamanDetail.buku'])
            ->whereDate('tgl_pinjam', '>=', $dateFrom)
            ->whereDate('tgl_pinjam', '<=', $dateTo)
            ->latest()
            ->paginate(15);

        $summary = DB::table('peminjamans')
            ->leftJoin('pengembalians', 'peminjamans.id', '=', 'pengembalians.peminjaman_id')
            ->whereDate('peminjamans.tgl_pinjam', '>=', $dateFrom)
            ->whereDate('peminjamans.tgl_pinjam', '<=', $dateTo)
            ->selectRaw('COUNT(peminjamans.id) as total_pinjam, SUM(pengembalians.denda) as total_denda')
            ->first();

        $byCategory = DB::table('peminjaman_details')
            ->join('bukus', 'bukus.id', '=', 'peminjaman_details.buku_id')
            ->select('bukus.rak_lokasi as kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('bukus.rak_lokasi')
            ->orderByDesc('total')
            ->get();

        return view('admin.reports.index', compact('peminjamans', 'summary', 'byCategory', 'dateFrom', 'dateTo'));
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