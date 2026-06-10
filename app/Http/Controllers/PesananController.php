<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Services\PesananService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Auth::user()->pesanans()
            ->with([
                'itemPesanans.buku',
                'itemPesanans.buku.peminjamans' => function ($q) {
                    $q->where('user_id', Auth::id())->with('pengembalian');
                }
            ])
            ->latest()
            ->paginate(10);

        return view('pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $pesanan->load([
            'itemPesanans.buku.peminjamans' => function ($q) {
                $q->where('user_id', Auth::id())->with('pengembalian');
            }
        ]);

        return view('pesanan.show', compact('pesanan'));
    }

    public function batal(Pesanan $pesanan, PesananService $pesananService)
    {
        return $pesananService->batal($pesanan);
    }

    public function kembalikanBuku(Request $request, $peminjamanId)
    {
        $peminjaman = Peminjaman::with('pesanan')
            ->where('id', $peminjamanId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $tglSeharusnya = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
            $tglAktual = Carbon::now()->startOfDay();

            $terlambat = $tglAktual->gt($tglSeharusnya) ? $tglAktual->diffInDays($tglSeharusnya) : 0;
            $denda = $terlambat * 1000;

            $peminjaman->update(['status' => 'dikembalikan']);

            if ($peminjaman->pesanan) {
                $peminjaman->pesanan->update(['status' => 'selesai']);
            }

            if ($peminjaman->buku) {
                $peminjaman->buku->increment('stok', 1);
            }

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali' => now(),
                'terlambat_hari' => $terlambat,
                'denda' => $denda,
                'denda_dibayar' => $denda == 0,
            ]);

            DB::commit();
            return back()->with('success', 'Buku berhasil dikembalikan dan status pesanan selesai!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian buku.');
        }
    }
}