<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Teknologi', 'deskripsi' => 'Buku tentang perkembangan IT dan Gadget.'],
            ['nama' => 'Sains', 'deskripsi' => 'Ilmu pengetahuan alam, fisika, dan biologi.'],
            ['nama' => 'Fiksi', 'deskripsi' => 'Novel, cerpen, dan karya imajinatif lainnya.'],
            ['nama' => 'Sejarah', 'deskripsi' => 'Catatan peristiwa masa lalu dunia dan nasional.'],
            ['nama' => 'Agama', 'deskripsi' => 'Buku tuntunan ibadah dan spiritual.'],
        ];

        foreach ($kategoris as $k) {
            $slug = Str::slug($k['nama']);
            Kategori::create([
                'nama' => $k['nama'],
                'slug' => $slug,
                'deskripsi' => $k['deskripsi'],
                'is_active' => true,
                'gambar' => 'icon-' . $slug . '.png',
            ]);
        }

        $this->command->info('Seeder Kategori berhasil dijalankan dengan nama file gambar!');
    }
}