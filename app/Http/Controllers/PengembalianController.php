<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalians = \App\Models\Pengembalian::with('peminjaman.pengguna')->get();
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengembalian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $peminjaman = Peminjaman::find($request->peminjaman_id);

        DB::beginTransaction();
        try {
            $peminjaman->update(['status' => 'kembali']);

            foreach ($peminjaman->peminjamanDetail as $detail) {
                $detail->buku->increment('stok', $detail->jumlah);
            }

            \App\Models\Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali_aktual' => Carbon::now(),
                'denda' => $request->denda ?? 0,
                'user_id' => auth()->id(),
            ]);

            return redirect()->back()->with('success', 'Buku telah dikembalikan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengembalians = \App\Models\Pengembalian::with('peminjaman.pengguna', 'peminjaman.peminjamanDetail.buku')->findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalians'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengembalians = \App\Models\Pengembalian::with('peminjaman.pengguna', 'peminjaman.peminjamanDetail.buku')->findOrFail($id);
        return view('admin.pengembalian.edit', compact('pengembalians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengembalians = \App\Models\Pengembalian::findOrFail($id);

        $request->validate([
            'denda' => 'nullable|numeric|min:0',
        ]);

        $pengembalians->update([
            'denda' => $request->denda ?? 0,
        ]);

        return redirect()->back()->with('success', 'Pengembalian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjamans = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {

            foreach ($peminjamans->peminjamanDetail as $detail) {
                $detail->buku->increment('stok', $detail->jumlah);
            }


            $peminjamans->peminjamanDetail()->delete();
            $peminjamans->delete();

            return redirect()->back()->with('success', 'Peminjaman berhasil dihapus!');
        }
    }
}
