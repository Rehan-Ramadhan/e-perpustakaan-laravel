<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // Isi kolom sesuai migration peminjaman
    protected $fillable = ['kode_transaksi', 'anggota_id', 'user_id', 'tgl_pinjam', 'tgl_harus_kembali', 'status'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
