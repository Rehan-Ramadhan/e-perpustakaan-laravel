<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'nomor_order', 'status', 'catatan'];

    public function items()
    {
        return $this->hasMany(ItemPesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class);
    }
}
