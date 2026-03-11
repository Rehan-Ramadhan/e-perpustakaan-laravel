<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'email',
        'password',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'role',
        'status'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id', 'id');
    }
}