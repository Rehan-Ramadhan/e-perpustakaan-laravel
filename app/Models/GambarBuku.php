<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GambarBuku extends Model
{
    protected $fillable = [
        'buku_id',
        'lokasi_sampul',
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
        if (str_starts_with($this->lokasi_sampul ?? '', 'http')) {
            return $this->lokasi_sampul;
        }

        return asset('storage/' . $this->lokasi_sampul);
    }


    /**
     * Fungsi otomatis Laravel saat model berinteraksi.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($gambar) {
            if ($gambar->lokasi_sampul && Storage::disk('public')->exists($gambar->lokasi_sampul)) {
                Storage::disk('public')->delete($gambar->lokasi_sampul);
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