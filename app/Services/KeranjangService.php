<?php

namespace App\Services;

use App\Models\Keranjang;
use App\Models\ItemKeranjang;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;

class KeranjangService
{
    public function getKeranjang()
    {
        return Keranjang::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function getItems()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->with('itemKeranjangs.buku.gambarBukus')
            ->first();

        return $keranjang ? $keranjang->itemKeranjangs : collect();
    }

    public function addBuku(int $bukuId, int $jumlah)
    {
        $buku = Buku::findOrFail($bukuId);
        $keranjang = $this->getKeranjang();

        $item = ItemKeranjang::where('keranjang_id', $keranjang->id)
            ->where('buku_id', $bukuId)
            ->first();

        if ($item) {
            throw new \Exception("buku '{$buku->nama}' sudah ada di daftar pinjam.");
        }

        ItemKeranjang::create([
            'keranjang_id' => $keranjang->id,
            'buku_id' => $bukuId,
            'jumlah' => 1
        ]);
    }

    public function updateJumlah(int $itemId, int $jumlah)
    {
        $item = ItemKeranjang::with('buku')->findOrFail($itemId);

        if ($item->keranjang->user_id !== Auth::id()) {
            abort(403, 'aksi tidak diizinkan.');
        }

        if ($jumlah > $item->buku->stok) {
            throw new \Exception("stok terbatas. hanya tersedia {$item->buku->stok}");
        }

        $item->update(['jumlah' => $jumlah]);
    }

    public function removeItem(int $itemId)
    {
        $item = ItemKeranjang::findOrFail($itemId);

        if ($item->keranjang->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();
    }
}