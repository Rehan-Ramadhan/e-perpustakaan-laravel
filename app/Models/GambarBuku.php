<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarBuku extends Model
{
    protected $fillable = ['buku_id', 'lokasi_sampul', 'is_primary', 'urutan'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
