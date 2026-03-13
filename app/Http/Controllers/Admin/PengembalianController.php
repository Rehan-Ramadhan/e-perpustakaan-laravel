<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.pengguna')->get();
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        return view('admin.pengembalian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        DB::beginTransaction();
        try {
            $tgl_kembali_seharusnya = Carbon::parse($peminjaman->tgl_harus_kembali)->startOfDay();
            $tgl_kembali_aktual = Carbon::now()->startOfDay();
            $denda = 0;
            $selisih_hari = 0;

            if ($tgl_kembali_aktual->gt($tgl_kembali_seharusnya)) {
                $selisih_hari = $tgl_kembali_aktual->diffInDays($tgl_kembali_seharusnya);
                $denda = $selisih_hari * 1000;
            }

            $peminjaman->update(['status' => 'kembali']);

            foreach ($peminjaman->peminjamanDetail as $detail) {
                $detail->buku->increment('stok', $detail->jumlah);
            }

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali_aktual' => Carbon::now(),
                'denda' => $denda,
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            $pesan = ($denda > 0)
                ? "Buku dikembalikan. Terlambat {$selisih_hari} hari, denda: Rp " . number_format($denda)
                : "Buku dikembalikan tepat waktu.";

            return redirect()->route('pengembalian.index')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $pengembalians = Pengembalian::with('peminjaman.pengguna', 'peminjaman.peminjamanDetail.buku')->findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalians'));
    }

    public function edit(string $id)
    {
        $pengembalians = Pengembalian::with('peminjaman.pengguna', 'peminjaman.peminjamanDetail.buku')->findOrFail($id);
        return view('admin.pengembalian.edit', compact('pengembalians'));
    }

    public function update(Request $request, string $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $peminjaman = $pengembalian->peminjaman;
        $tgl_seharusnya = \Carbon\Carbon::parse($peminjaman->tgl_harus_kembali);
        $tgl_aktual = \Carbon\Carbon::parse($pengembalian->tgl_kembali_aktual);

        $denda_baru = 0;
        if ($tgl_aktual->gt($tgl_seharusnya)) {
            $selisih = $tgl_aktual->diffInDays($tgl_seharusnya);
            $denda_baru = $selisih * 1000;
        }

        $pengembalian->update([
            'denda' => $denda_baru,
        ]);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Data pengembalian telah diperbarui (Denda dikalkulasi ulang).')
            ->with('alert-type', 'info');
    }

    public function destroy(string $id)
    {
        $pengembalians = Pengembalian::findOrFail($id);

        DB::beginTransaction();
        try {
            $peminjaman = $pengembalians->peminjaman;

            if ($peminjaman) {
                $peminjaman->update(['status' => 'pinjam']);
                foreach ($peminjaman->peminjamanDetail as $detail) {
                    $detail->buku->decrement('stok', $detail->jumlah);
                }
            }

            $pengembalians->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}