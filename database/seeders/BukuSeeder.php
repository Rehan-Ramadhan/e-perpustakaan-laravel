<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $kategoriIds = \App\Models\Kategori::pluck('id');

        for ($i = 1; $i <= 15; $i++) {
            \App\Models\Buku::create([
                'kategori_id' => $kategoriIds->random(),
                'nama' => 'Buku ' . $faker->sentence(3),
                'slug' => 'buku-' . $i . '-' . time(),
                'pengarang' => $faker->name,
                'penerbit' => 'Penerbit ' . $faker->company,
                'tahun_terbit' => rand(2015, 2024),
                'lokasi_rak' => 'Rak ' . rand(1, 10),
                'deskripsi' => $faker->paragraph,
                'stok' => rand(5, 20),
                'is_active' => true,
                'is_featured' => $i <= 3 ? true : false, // 3 buku pertama jadi featured
            ]);
        }
    }
}
