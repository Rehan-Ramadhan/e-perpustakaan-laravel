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

            $lastTransaction = Peminjaman::whereDate('created_at', Carbon::today())
                ->orderBy('id', 'desc')
                ->first();

            if ($lastTransaction) {
                $lastNumber = (int) substr($lastTransaction->kode_transaksi, -3);
                $count = $lastNumber + 1;
            } else {
                $count = 1;
            }

            $kode = $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $peminjamans = Peminjaman::create([
                'kode_transaksi' => $kode,
                'pengguna_id' => $request->pengguna_id,
                'tgl_pinjam' => Carbon::now(),
                'tgl_harus_kembali' => Carbon::now()->addDays(7),
                'status' => 'pinjam',
            ]);

            foreach ($request->buku_ids as $buku_id) {
                $bukus = Buku::find($buku_id);

                if (!$bukus || $bukus->stok < 1) {
                    throw new \Exception("Stok buku '{$bukus->judul}' sudah habis.");
                }

                $bukus->decrement('stok', 1);

                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjamans->id,
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
                ->with('alert-type', 'danger')
                ->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(string $id)
    {
        $peminjamans = Peminjaman::with(['pengguna', 'peminjamanDetail.buku'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjamans'));
    }

    /**
     * Menampilkan halaman edit (misal perpanjang durasi).
     */
    public function edit(string $id)
    {
        $peminjamans = Peminjaman::findOrFail($id);
        return view('admin.peminjaman.edit', compact('peminjamans'));
    }

    /**
     * Memperbarui data transaksi (Perpanjang Masa Pinjam).
     */
    public function update(Request $request, string $id)
    {
        $peminjamans = Peminjaman::findOrFail($id);

        $request->validate([
            'tgl_pinjam' => 'required|date',
        ], [
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
        ]);

        $tglPinjam = Carbon::parse($request->tgl_pinjam);
        $tglHarusKembali = $tglPinjam->copy()->addDays(7);

        $peminjamans->update([
            'tgl_pinjam' => $tglPinjam,
            'tgl_harus_kembali' => $tglHarusKembali,
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!')
            ->with('alert-type', 'info');
    }

    /**
     * Menghapus transaksi dan mengembalikan stok buku.
     */
    public function destroy(string $id)
    {
        $peminjamans = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($peminjamans->status === 'pinjam') {
                foreach ($peminjamans->peminjamanDetail as $detail) {
                    $detail->buku->increment('stok', $detail->jumlah);
                }
            }

            $peminjamans->peminjamanDetail()->delete();
            $peminjamans->delete();

            DB::commit();
            return redirect()->route('peminjaman.index')
                ->with('success', 'Transaksi berhasil dihapus!')
                ->with('alert-type', 'danger');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data.')
                ->with('alert-type', 'danger');
        }
    }
}