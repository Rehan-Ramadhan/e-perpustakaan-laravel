<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GambarBuku extends Model
{
    protected $fillable = [
        'buku_id',
        'lokasi_gambar',
        'is_primary',
        'urutan',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];


    /**
     * Relasi balik ke Buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }


    /**
     * URL gambar lengkap.
     * Akses: $gambar->url_gambar
     */
    public function getUrlGambarAttribute(): string
    {
        if (str_starts_with($this->lokasi_gambar ?? '', 'http')) {
            return $this->lokasi_gambar;
        }

        return asset('storage/' . $this->lokasi_gambar);
    }


    /**
     * Fungsi otomatis Laravel saat model berinteraksi.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gambar) {
            if ($gambar->lokasi_gambar && Storage::disk('public')->exists($gambar->lokasi_gambar)) {
                Storage::disk('public')->delete($gambar->lokasi_gambar);
            }
        });
    }

    /**
     * Set gambar ini sebagai gambar utama (primary) buku.
     */
    public function jadikanUtama(): void
    {
        $this->buku->gambars()
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);
        $this->update(['is_primary' => true]);
    }
}