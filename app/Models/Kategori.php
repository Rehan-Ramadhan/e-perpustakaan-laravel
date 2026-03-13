<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (Mass Assignment).
     * Sesuai migration: nama, slug, deskripsi, gambar, is_active.
     */
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'gambar',
        'is_active',
    ];

    /**
     * Casting tipe data.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi One-to-Many: Satu Kategori memiliki BANYAK Buku.
     */
    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }

    /**
     * Relasi Buku yang sedang aktif (tersedia).
     */
    public function bukuAktif(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_id')
            ->where('is_active', true)
            ->where('stok', '>', 0);
    }

    /**
     * Filter Kategori yang statusnya aktif.
     * Cara pakai: Kategori::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Mendapatkan URL Gambar Kategori.
     * Akses: $kategori->gambar_url
     */
    public function getGambarUrlAttribute(): string
    {
        if (!$this->gambar) {
            return asset('assets/img/illustrations/page-misc-error-light.png');
        }

        if (str_contains($this->gambar, 'kategoris/')) {
            return asset('storage/' . $this->gambar);
        }

        return asset('assets/img/elements/' . $this->gambar);
    }

    /**
     * Menghitung jumlah buku dalam kategori ini.
     * Akses: $kategori->jumlah_buku
     */
    public function getJumlahBukuAttribute(): int
    {
        return $this->bukus()->count();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });

        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama')) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });
    }
}