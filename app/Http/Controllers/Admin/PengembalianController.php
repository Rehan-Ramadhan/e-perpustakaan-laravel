<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.user', 'peminjaman.buku')->latest()->get();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam')
            ->get();

        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ], [
            'peminjaman_id.required' => 'Nomor peminjaman wajib dipilih.',
            'peminjaman_id.exists' => 'Data peminjaman tidak valid.',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        DB::beginTransaction();

        try {
            $tglSeharusnya = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
            $tglAktual = Carbon::now()->startOfDay();

            $terlambat = 0;
            $denda = 0;

            if ($tglAktual->gt($tglSeharusnya)) {
                $terlambat = $tglAktual->diffInDays($tglSeharusnya);
                $denda = $terlambat * 1000;
            }

            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);

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

            $pesan = $denda > 0
                ? "Pengembalian berhasil. Terlambat {$terlambat} hari, denda Rp " . number_format($denda, 0, ',', '.')
                : "Pengembalian berhasil. Buku dikembalikan tepat waktu.";

            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', $pesan)
                ->with('alert-type', 'primary');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data pengembalian.');
        }
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load('peminjaman.user', 'peminjaman.buku');

        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load('peminjaman.user', 'peminjaman.buku');

        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $peminjaman = $pengembalian->peminjaman;

        try {
            $tglSeharusnya = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
            $tglKembali = Carbon::parse($pengembalian->tanggal_kembali)->startOfDay();

            $terlambat = 0;
            $denda = 0;

            if ($tglKembali->gt($tglSeharusnya)) {
                $terlambat = $tglKembali->diffInDays($tglSeharusnya);
                $denda = $terlambat * 1000;
            }

            $pengembalian->update([
                'terlambat_hari' => $terlambat,
                'denda' => $denda,
            ]);

            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', 'Data pengembalian berhasil diperbarui.')
                ->with('alert-type', 'warning');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data pengembalian.');
        }
    }

    public function destroy(Pengembalian $pengembalian)
    {
        DB::beginTransaction();

        try {
            $peminjaman = $pengembalian->peminjaman;

            if ($peminjaman) {
                $peminjaman->update(['status' => 'dipinjam']);

                if ($peminjaman->buku) {
                    $peminjaman->buku->decrement('stok', 1);
                }
            }

            $pengembalian->delete();

            DB::commit();

            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', 'Data pengembalian berhasil dihapus.')
                ->with('alert-type', 'danger');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data pengembalian.');
        }
    }
}