<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'pesanan_id',
        'user_id',
        'buku_id',
        'nomor_peminjaman',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'dipinjam' => 'primary',
            'dikembalikan' => 'success',
            'terlambat' => 'danger',
            default => 'secondary',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}