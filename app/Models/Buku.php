<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = ['kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun', 'stok', 'rak_lokasi'];

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }
}
