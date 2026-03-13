<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPesanan extends Model
{
    protected $fillable = ['pesanan_id', 'buku_id', 'nama_buku', 'quantity'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
