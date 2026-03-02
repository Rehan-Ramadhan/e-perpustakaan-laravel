<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['nik', 'nama', 'alamat', 'telepon', 'jenis_kelamin', 'pekerjaan'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
