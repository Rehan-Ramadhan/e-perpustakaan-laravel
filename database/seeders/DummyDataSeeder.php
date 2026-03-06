<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pengguna::truncate();
        Buku::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $penggunas = [
            ['nik' => '320101001', 'nama' => 'Rizky', 'telepon' => '08123456789', 'alamat' => 'Bandung'],
            ['nik' => '320101002', 'nama' => 'Siti', 'telepon' => '08987654321', 'alamat' => 'Jakarta'],
            ['nik' => '320101003', 'nama' => 'Budi', 'telepon' => '08666666666', 'alamat' => 'Yogyakarta'],
        ];

        foreach ($penggunas as $p) {
            Pengguna::create($p);
        }

        $bukus = [
            [
                'kode_buku' => 'B001',
                'judul' => 'Pemrograman Laravel 12',
                'pengarang' => 'Andi Publisher',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2024,
                'stok' => 10,
                'rak_lokasi' => 'A1'
            ],
            [
                'kode_buku' => 'B002',
                'judul' => 'Clean Code',
                'pengarang' => 'Robert C. Martin',
                'penerbit' => 'Pearson',
                'tahun_terbit' => 2008,
                'stok' => 5,
                'rak_lokasi' => 'B2'
            ],
            [
                'kode_buku' => 'B003',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2018,
                'stok' => 15,
                'rak_lokasi' => 'C1'
            ],
        ];

        foreach ($bukus as $b) {
            Buku::create($b);
        }
    }
}