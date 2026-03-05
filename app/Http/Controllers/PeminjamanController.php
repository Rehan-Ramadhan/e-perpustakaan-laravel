<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with('pengguna')->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form transaksi baru.
     */
    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        $penggunas = \App\Models\Pengguna::all();
        return view('admin.peminjaman.create', compact('bukus', 'penggunas'));
    }

    /**
     * Menyimpan transaksi peminjaman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:penggunas,id',
            'buku_ids' => 'required|array',
            'buku_ids.*' => 'exists:bukus,id',
        ], [
            'pengguna_id.required' => 'Nama peminjam wajib dipilih.',
            'buku_ids.required' => 'Pilih minimal satu buku.',
        ]);

        DB::beginTransaction();

        try {
            $tgl = Carbon::now()->format('Ymd');
            $count = Peminjaman::whereDate('created_at', Carbon::today())->count() + 1;
            $kode = $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $peminjaman = Peminjaman::create([
                'kode_transaksi' => $kode,
                'pengguna_id' => $request->pengguna_id,
                'tgl_pinjam' => Carbon::now(),
                'tgl_harus_kembali' => Carbon::now()->addDays(7),
                'status' => 'pinjam',
            ]);

            foreach ($request->buku_ids as $buku_id) {
                $buku = Buku::find($buku_id);

                if ($buku->stok < 1) {
                    throw new \Exception("Stok buku '{$buku->judul}' sudah habis.");
                }

                $buku->decrement('stok', 1);

                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $buku_id,
                    'jumlah' => 1,
                ]);
            }

            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dicatat! Kode: ' . $kode)
                ->with('alert-type', 'primary');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memproses transaksi: ' . $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['pengguna', 'peminjamanDetail.buku'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Menampilkan halaman edit (misal perpanjang durasi).
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    /**
     * Memperbarui data transaksi (Perpanjang Masa Pinjam).
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tgl_harus_kembali' => 'required|date|after_or_equal:today',
        ], [
            'tgl_harus_kembali.required' => 'Tanggal harus kembali wajib diisi.',
            'tgl_harus_kembali.after_or_equal' => 'Tanggal harus kembali tidak boleh sebelum hari ini.',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'tgl_harus_kembali' => $request->tgl_harus_kembali,
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Masa pinjam berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    /**
     * Menghapus transaksi dan mengembalikan stok buku.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($peminjaman->status === 'pinjam') {
                foreach ($peminjaman->peminjamanDetail as $detail) {
                    $detail->buku->increment('stok', $detail->jumlah);
                }
            }

            $peminjaman->peminjamanDetail()->delete();
            $peminjaman->delete();

            DB::commit();
            return redirect()->route('peminjaman.index')
                ->with('success', 'Data transaksi berhasil dihapus!')
                ->with('alert-type', 'warning');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data.')
                ->with('alert-type', 'danger');
        }
    }
}