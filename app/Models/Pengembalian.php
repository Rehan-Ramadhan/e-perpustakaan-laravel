<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = ['peminjaman_id', 'tgl_kembali_aktual', 'denda', 'user_id'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}