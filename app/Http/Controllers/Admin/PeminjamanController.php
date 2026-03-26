<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
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
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form transaksi baru.
     */
    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        $users = User::all();
        return view('admin.peminjaman.create', compact('bukus', 'users'));
    }

    /**
     * Menyimpan transaksi peminjaman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
        ], [
            'user_id.required' => 'Peminjam wajib dipilih.',
            'user_id.exists' => 'Peminjam tidak valid.',
            'buku_id.required' => 'Buku wajib dipilih.',
            'buku_id.exists' => 'Buku tidak valid.',
        ]);

        DB::beginTransaction();

        try {
            $tgl = Carbon::now()->format('Ymd');
            $last = Peminjaman::whereDate('created_at', Carbon::today())->latest()->first();
            $count = $last ? ((int) substr($last->nomor_peminjaman, -3) + 1) : 1;

            $nomor = 'PMJ-' . $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $buku = Buku::find($request->buku_id);

            if (!$buku || $buku->stok < 1) {
                throw new \Exception("Stok buku sedang tidak tersedia.");
            }

            Peminjaman::create([
                'pesanan_id' => null,
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id,
                'nomor_peminjaman' => $nomor,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => now()->addDays(7),
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok', 1);

            DB::commit();

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Buku berhasil dipinjam!')
                ->with('alert-type', 'primary');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(string $id)
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->findOrFail($id);
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
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal_pinjam' => 'required|date',
        ], [
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.date' => 'Format tanggal tidak valid.',
        ]);

        $tglPinjam = Carbon::parse($request->tanggal_pinjam);
        $jatuhTempo = $tglPinjam->copy()->addDays(7);

        $peminjaman->update([
            'tanggal_pinjam' => $tglPinjam,
            'tanggal_jatuh_tempo' => $jatuhTempo,
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!')
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
            if ($peminjaman->status === 'dipinjam') {
                if ($peminjaman->buku) {
                    $peminjaman->buku->increment('stok', 1);
                }
            }

            $peminjaman->delete();

            DB::commit();

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!')
                ->with('alert-type', 'danger');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }
}