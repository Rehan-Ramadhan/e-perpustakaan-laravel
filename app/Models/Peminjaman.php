<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'nomor_peminjaman',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status'
    ];

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
