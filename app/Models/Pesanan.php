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

    protected $fillable = ['user_id', 'nomor_order', 'status', 'catatan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemPesanan::class);
    }

    public function peminjaman(): HasOne
    {
        return $this->hasOne(Peminjaman::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'tertunda';
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}