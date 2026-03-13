<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','nomor_order','status','catatan',];

    /**
     * Relasi: Pesanan dimiliki oleh satu User (Anggota)
     * Digunakan untuk melihat siapa yang melakukan booking buku.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu pesanan memiliki banyak item buku.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemPesanan::class);
    }

    /**
     * Relasi: Pesanan ini berlanjut menjadi satu data peminjaman resmi.
     */
    public function peminjaman(): HasOne
    {
        return $this->hasOne(Peminjaman::class);
    }

    /**
     * Cek apakah status pesanan masih tertunda (Pending).
     */
    public function isPending(): bool
    {
        return $this->status === 'tertunda';
    }

    /**
     * Scope untuk mempermudah pencarian berdasarkan status di Controller Admin.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}