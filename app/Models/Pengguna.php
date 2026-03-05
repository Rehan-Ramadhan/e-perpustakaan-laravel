<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $fillable = ['nik', 'nama', 'jenis_kelamin', 'telepon', 'alamat'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
