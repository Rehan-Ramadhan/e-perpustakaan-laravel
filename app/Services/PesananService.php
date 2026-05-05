<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\User;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesananService
{
    public function buatPesanan(User $user, ?string $catatan = null): Pesanan
    {
        $keranjang = Keranjang::where('user_id', $user->id)
            ->with('itemKeranjangs.buku')
            ->first();

        if (!$keranjang || !$keranjang->itemKeranjangs || $keranjang->itemKeranjangs->isEmpty()) {
            throw new \Exception("Daftar pinjam kosong.");
        }

        return DB::transaction(function () use ($user, $keranjang, $catatan) {
            foreach ($keranjang->itemKeranjangs as $item) {
                if (!$item->buku || $item->buku->stok < 1) {
                    throw new \Exception("Buku '{$item->buku->nama}' baru saja habis.");
                }
            }

            $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'nomor_order' => 'REQ-' . strtoupper(Str::random(10)),
                'status' => 'tertunda',
                'catatan' => $catatan,
            ]);

            foreach ($keranjang->itemKeranjangs as $item) {
                $pesanan->itemPesanans()->create([
                    'buku_id' => $item->buku_id,
                    'nama_buku' => $item->buku->nama,
                    'jumlah' => 1,
                ]);

                $item->buku->decrement('stok', 1);
            }

            $keranjang->itemKeranjangs()->delete();

            return $pesanan;
        });
    }
}