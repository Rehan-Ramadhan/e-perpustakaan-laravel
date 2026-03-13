<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'terlambat_hari',
        'denda',
        'denda_dibayar'
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda_dibayar' => 'boolean',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
