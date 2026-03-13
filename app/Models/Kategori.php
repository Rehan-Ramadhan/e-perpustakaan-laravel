<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'slug', 'deskripsi', 'gambar', 'is_active'];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
