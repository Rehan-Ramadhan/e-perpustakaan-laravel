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
            ->with('items.buku.gambarBukus')
            ->first();

        return $keranjang ? $keranjang->items : collect();
    }

    public function addBuku(int $bukuId, int $jumlah)
    {
        $buku = Buku::findOrFail($bukuId);
        $keranjang = $this->getKeranjang();

        if ($buku->stok < $jumlah) {
            throw new \Exception("Stok tidak mencukupi. Sisa: {$buku->stok}");
        }

        $item = ItemKeranjang::where('keranjang_id', $keranjang->id)
            ->where('buku_id', $bukuId)
            ->first();

        if ($item) {
            $totalBaru = $item->jumlah + $jumlah;
            if ($totalBaru > $buku->stok) {
                throw new \Exception("Total di keranjang melebihi stok. Maksimal: {$buku->stok}");
            }
            $item->increment('jumlah', $jumlah);
        } else {
            ItemKeranjang::create([
                'keranjang_id' => $keranjang->id,
                'buku_id' => $bukuId,
                'jumlah' => $jumlah
            ]);
        }
    }

    public function updateJumlah(int $itemId, int $jumlah)
    {
        $item = ItemKeranjang::with('buku')->findOrFail($itemId);

        if ($item->keranjang->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($jumlah > $item->buku->stok) {
            throw new \Exception("Stok terbatas. Hanya tersedia {$item->buku->stok}");
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