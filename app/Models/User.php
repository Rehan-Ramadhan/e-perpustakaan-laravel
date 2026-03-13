<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'telepon',
        'alamat',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * User memiliki satu keranjang aktif.
     */
    public function keranjang(): HasOne
    {
        return $this->hasOne(Keranjang::class);
    }

    /**
     * User memiliki banyak buku di daftar keinginan (Wishlist).
     */
    public function keinginan(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'keinginans')
            ->withTimestamps();
    }

    /**
     * User memiliki banyak pesanan (Booking).
     */
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * User memiliki banyak riwayat peminjaman.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah pengguna biasa.
     */
    public function isPengguna(): bool
    {
        return $this->role === 'pengguna';
    }

    /**
     * Cek apakah buku ada di daftar keinginan user.
     */
    public function hasInKeinginan(Buku $buku): bool
    {
        return $this->keinginan()
            ->where('buku_id', $buku->id)
            ->exists();
    }


    /**
     * Mendapatkan URL Avatar dengan logika prioritas:
     * 1. Storage Lokal (Upload)
     * 2. URL Eksternal (Google)
     * 3. Fallback (Gravatar)
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        if (str_starts_with($this->avatar ?? '', 'http')) {
            return $this->avatar;
        }

        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    /**
     * Mendapatkan inisial nama untuk UI fallback.
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}