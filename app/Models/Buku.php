<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Buku extends Model
{
    use HasFactory, LogsActivity;

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
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'stok', 'kategori_id', 'lokasi_rak'])
            ->logOnlyDirty()
            ->useLogName('buku');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($buku) {
            if (empty($buku->slug)) {
                $buku->slug = static::generateUniqueSlug($buku->nama);
            }
        });

        static::updating(function ($buku) {
            if ($buku->isDirty('nama')) {
                $buku->slug = static::generateUniqueSlug($buku->nama, $buku->id);
            }
        });
    }

    private static function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->when($id, fn($q) => $q->where('id', '!=', $id))->exists()) {
            $slug = $originalSlug . '-' . ($count++);
        }

        return $slug;
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function gambarBukus(): HasMany
    {
        return $this->hasMany(GambarBuku::class)->orderBy('urutan');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(GambarBuku::class)->where('is_primary', true);
    }

    public function itemPesanans(): HasMany
    {
        return $this->hasMany(ItemPesanan::class);
    }


    public function getImageUrlAttribute(): string
    {
        if ($this->primaryImage && $this->primaryImage->lokasi_sampul) {
            return asset('storage/' . $this->primaryImage->lokasi_sampul);
        } elseif ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('assets/img/elements/18.jpg');
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->stok <= 0)
            return 'Kosong';
        if ($this->stok <= 3)
            return 'Hampir Habis';
        return 'Tersedia';
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->stok <= 0)
            return 'danger';
        if ($this->stok <= 3)
            return 'warning';
        return 'success';
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
                ->orWhere('pengarang', 'like', "%{$keyword}%")
                ->orWhere('penerbit', 'like', "%{$keyword}%");
        });
    }

    public function pinjam(int $jumlah = 1): bool
    {
        if ($this->stok < $jumlah)
            return false;
        return $this->decrement('stok', $jumlah);
    }

    public function kembali(int $jumlah = 1): void
    {
        $this->increment('stok', $jumlah);
    }
}
