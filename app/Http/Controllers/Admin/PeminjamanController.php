<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('admin.peminjaman.index', [
            'antreanPesanan' => Pesanan::with(['user', 'itemPesanans.buku'])->where('status', 'tertunda')->latest()->get(),
            'peminjamans' => Peminjaman::with(['user', 'buku'])->latest()->get(),
        ]);
    }

    public function setujuiPesanan(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::with(['itemPesanans.buku', 'user'])->findOrFail($id);
            $tgl = Carbon::now()->format('Ymd');

            $last = Peminjaman::whereDate('created_at', Carbon::today())->latest()->first();
            $nextCount = $last ? ((int) substr($last->nomor_peminjaman, -3) + 1) : 1;

            foreach ($pesanan->itemPesanans as $item) {
                $nomor = 'PMJ-' . $tgl . '-' . str_pad($nextCount, 3, '0', STR_PAD_LEFT);

                Peminjaman::create([
                    'pesanan_id' => $pesanan->id,
                    'user_id' => $pesanan->user_id,
                    'buku_id' => $item->buku_id,
                    'nomor_peminjaman' => $nomor,
                    'tanggal_pinjam' => now(),
                    'tanggal_jatuh_tempo' => now()->addDays(7),
                    'status' => 'dipinjam',
                ]);

                $nextCount++;
            }

            $pesanan->update(['status' => 'selesai']);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan disetujui. Batas waktu pinjam 7 hari dari sekarang.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function tolakPesanan(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::with('itemPesanans.buku')->findOrFail($id);

            foreach ($pesanan->itemPesanans as $item) {
                if ($item->buku) {
                    $item->buku->increment('stok', 1);
                }
            }

            $pesanan->update(['status' => 'dibatalkan']);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan #' . $pesanan->nomor_order . ' telah ditolak dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak pesanan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.peminjaman.create', [
            'bukus' => Buku::where('stok', '>', 0)->get(),
            'users' => User::all(),
        ]);
    }

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

        try {
            DB::beginTransaction();

            $buku = Buku::findOrFail($request->buku_id);
            if ($buku->stok < 1) {
                throw new \Exception('Stok buku habis.');
            }

            $tgl = Carbon::now()->format('Ymd');
            $last = Peminjaman::whereDate('created_at', Carbon::today())->latest()->first();
            $count = $last ? ((int) substr($last->nomor_peminjaman, -3) + 1) : 1;
            $nomor = 'PMJ-' . $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            Peminjaman::create([
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id,
                'nomor_peminjaman' => $nomor,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => now()->addDays(7),
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok', 1);

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku', 'pesanan']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        try {
            $peminjaman->update([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            ]);
            return redirect()->route('admin.peminjaman.index')->with('success', 'Batas waktu berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::beginTransaction();
        try {
            if ($peminjaman->status === 'dipinjam' && $peminjaman->buku) {
                $peminjaman->buku->increment('stok', 1);
            }
            $peminjaman->delete();
            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal dihapus.');
        }
    }
}