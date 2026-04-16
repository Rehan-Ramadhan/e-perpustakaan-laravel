<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->with('items.buku.gambarBukus')
            ->first();

        $items = $keranjang ? $keranjang->items : collect();
        $totalBuku = $items->sum('jumlah');

        return view('keranjang.index', compact('items', 'totalBuku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $keranjang = Keranjang::firstOrCreate(['user_id' => Auth::id()]);

        $item = ItemKeranjang::where('keranjang_id', $keranjang->id)
            ->where('buku_id', $request->buku_id)
            ->first();

        if ($item) {
            $item->increment('jumlah', $request->jumlah);
        } else {
            ItemKeranjang::create([
                'keranjang_id' => $keranjang->id,
                'buku_id' => $request->buku_id,
                'jumlah' => $request->jumlah
            ]);
        }

        return back()->with('success', 'Buku berhasil dimasukkan ke daftar pinjam.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $item = ItemKeranjang::findOrFail($id);
        $item->update(['jumlah' => $request->jumlah]);

        return back()->with('success', 'Jumlah buku diperbarui.');
    }

    public function destroy($id)
    {
        ItemKeranjang::findOrFail($id)->delete();
        return back()->with('success', 'Buku dihapus dari daftar.');
    }
}