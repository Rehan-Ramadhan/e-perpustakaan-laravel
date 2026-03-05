<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [ 'kode_transaksi', 'pengguna_id', 'tgl_pinjam', 'tgl_harus_kembali', 'status'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
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