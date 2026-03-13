<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemKeranjang extends Model
{
    protected $fillable = ['keranjang_id', 'buku_id', 'kuantitas'];

    public function keranjang(): BelongsTo
    {
        return $this->belongsTo(Keranjang::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
}