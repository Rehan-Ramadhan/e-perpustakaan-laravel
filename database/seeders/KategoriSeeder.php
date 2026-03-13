<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Teknologi', 'slug' => 'teknologi'],
            ['nama' => 'Sains', 'slug' => 'sains'],
            ['nama' => 'Fiksi', 'slug' => 'fiksi'],
            ['nama' => 'Sejarah', 'slug' => 'sejarah'],
            ['nama' => 'Agama', 'slug' => 'agama'],
        ];

        foreach ($kategoris as $k) {
            \App\Models\Kategori::create($k);
        }
    }
}
