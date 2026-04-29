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
            'antreanPesanan' => Pesanan::with(['user', 'items.buku'])->where('status', 'tertunda')->latest()->get(),
            'peminjamans' => Peminjaman::with(['user', 'buku'])->latest()->get(),
        ]);
    }

    public function setujuiPesanan(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::with(['items.buku', 'user'])->findOrFail($id);

            foreach ($pesanan->items as $item) {
                $tgl = Carbon::now()->format('Ymd');
                $last = Peminjaman::whereDate('created_at', Carbon::today())->latest()->first();
                $count = $last ? ((int) substr($last->nomor_peminjaman, -3) + 1) : 1;
                $nomor = 'PMJ-' . $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                Peminjaman::create([
                    'pesanan_id' => $pesanan->id,
                    'user_id' => $pesanan->user_id,
                    'buku_id' => $item->buku_id,
                    'nomor_peminjaman' => $nomor,
                    'tanggal_pinjam' => now(),
                    'tanggal_jatuh_tempo' => now()->addDays(7),
                    'status' => 'dipinjam',
                ]);
            }

            $pesanan->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->back()->with('success', 'Pesanan berhasil disetujui menjadi peminjaman.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
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
        try {
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

            $tgl = Carbon::now()->format('Ymd');
            $last = Peminjaman::whereDate('created_at', Carbon::today())->latest()->first();
            $count = $last ? ((int) substr($last->nomor_peminjaman, -3) + 1) : 1;
            $nomor = 'PMJ-' . $tgl . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $buku = Buku::find($request->buku_id);

            if (!$buku || $buku->stok < 1) {
                throw ValidationException::withMessages([
                    'buku_id' => 'Stok buku tidak tersedia.',
                ]);
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

            return redirect()
                ->route('admin.peminjaman.index')
                ->with('success', 'Transaksi peminjaman berhasil ditambahkan.')
                ->with('alert-type', 'primary');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()->with('error', 'Data peminjaman gagal disimpan.');
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        try {
            $request->validate(['tanggal_pinjam' => 'required|date']);
            $tglPinjam = Carbon::parse($request->tanggal_pinjam);
            $peminjaman->update([
                'tanggal_pinjam' => $tglPinjam,
                'tanggal_jatuh_tempo' => $tglPinjam->copy()->addDays(7),
            ]);
            return redirect()->route('admin.peminjaman.index')->with('success', 'Data diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal diperbarui.');
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