<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'lokasi_rak',
        'deskripsi',
        'gambar',
        'stok',
        'is_active',
        'is_featured'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function gambars(): HasMany
    {
        return $this->hasMany(GambarBuku::class, 'buku_id');
    }
}
