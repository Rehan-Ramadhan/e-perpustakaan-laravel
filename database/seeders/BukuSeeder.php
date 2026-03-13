<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = Kategori::pluck('id', 'slug');

        $bukus = [
            // teknologi
            [
                'nama' => 'Belajar Laravel 11 untuk Pemula',
                'kategori' => 'teknologi',
                'pengarang' => 'Budi Raharjo',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2024,
                'lokasi_rak' => 'T-01',
                'gambar' => 'laravel-11.jpg',
                'deskripsi' => 'Panduan lengkap membangun aplikasi web modern dengan Laravel 11.',
            ],
            [
                'nama' => 'Kecerdasan Buatan (AI) Masa Kini',
                'kategori' => 'teknologi',
                'pengarang' => 'Dr. Suyanto',
                'penerbit' => 'Andi Offset',
                'tahun_terbit' => 2023,
                'lokasi_rak' => 'T-02',
                'gambar' => 'ai-masakin.jpg',
                'deskripsi' => 'Mengenal konsep neural networks dan machine learning secara mendalam.',
            ],
            [
                'nama' => 'Cyber Security Dasar',
                'kategori' => 'teknologi',
                'pengarang' => 'Onno W. Purbo',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 2022,
                'lokasi_rak' => 'T-03',
                'gambar' => 'cyber-sec.jpg',
                'deskripsi' => 'Cara mengamankan jaringan komputer dari serangan peretas.',
            ],

            // sains
            [
                'nama' => 'Kosmos: Alam Semesta',
                'kategori' => 'sains',
                'pengarang' => 'Carl Sagan',
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'tahun_terbit' => 2021,
                'lokasi_rak' => 'S-01',
                'gambar' => 'kosmos.jpg',
                'deskripsi' => 'Menjelajahi evolusi alam semesta dan peradaban manusia.',
            ],
            [
                'nama' => 'Prinsip Dasar Biologi Molekuler',
                'kategori' => 'sains',
                'pengarang' => 'Prof. Ahmad',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2020,
                'lokasi_rak' => 'S-02',
                'gambar' => 'biologi-mol.jpg',
                'deskripsi' => 'Pembahasan mendalam mengenai struktur DNA dan genetika.',
            ],
            [
                'nama' => 'Fisika Kuantum untuk Awam',
                'kategori' => 'sains',
                'pengarang' => 'Albert Wijaya',
                'penerbit' => 'Bumi Aksara',
                'tahun_terbit' => 2023,
                'lokasi_rak' => 'S-03',
                'gambar' => 'fisika-kuantum.jpg',
                'deskripsi' => 'Memahami dunia atom dengan bahasa yang sederhana.',
            ],

            // fiksi
            [
                'nama' => 'Negeri Di Ujung Tanduk',
                'kategori' => 'fiksi',
                'pengarang' => 'Tere Liye',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2018,
                'lokasi_rak' => 'F-01',
                'gambar' => 'negeri-ujung.jpg',
                'deskripsi' => 'Sebuah kisah tentang intrik politik dan perjuangan prinsip.',
            ],
            [
                'nama' => 'Laskar Pelangi',
                'kategori' => 'fiksi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'lokasi_rak' => 'F-02',
                'gambar' => 'laskar-pelangi.jpg',
                'deskripsi' => 'Kisah inspiratif anak-anak Belitong menggapai mimpi.',
            ],
            [
                'nama' => 'Cantik Itu Luka',
                'kategori' => 'fiksi',
                'pengarang' => 'Eka Kurniawan',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2015,
                'lokasi_rak' => 'F-03',
                'gambar' => 'cantik-luka.jpg',
                'deskripsi' => 'Novel realisme magis yang telah diterjemahkan ke banyak bahasa.',
            ],

            // sejarah
            [
                'nama' => 'Sejarah Dunia yang Disembunyikan',
                'kategori' => 'sejarah',
                'pengarang' => 'Jonathan Black',
                'penerbit' => 'Alvabet',
                'tahun_terbit' => 2019,
                'lokasi_rak' => 'SJ-01',
                'gambar' => 'sejarah-dunia.jpg',
                'deskripsi' => 'Menelisik sisi lain sejarah dari perspektif perkumpulan rahasia.',
            ],
            [
                'nama' => 'Gadjah Mada: Hamukti Palapa',
                'kategori' => 'sejarah',
                'pengarang' => 'Langit Kresna Hariadi',
                'penerbit' => 'Tiga Serangkai',
                'tahun_terbit' => 2017,
                'lokasi_rak' => 'SJ-02',
                'gambar' => 'gadjah-mada.jpg',
                'deskripsi' => 'Kisah kejayaan Majapahit di bawah sumpah sang Mahapatih.',
            ],
            [
                'nama' => 'Api Sejarah',
                'kategori' => 'sejarah',
                'pengarang' => 'Ahmad Mansur',
                'penerbit' => 'Salam Madani',
                'tahun_terbit' => 2015,
                'lokasi_rak' => 'SJ-03',
                'gambar' => 'api-sejarah.jpg',
                'deskripsi' => 'Mahakarya perjuangan ulama dan santri dalam menjaga NKRI.',
            ],

            // agama
            [
                'nama' => 'La Tahzan: Jangan Bersedih',
                'kategori' => 'agama',
                'pengarang' => 'Dr. Aidh al-Qarni',
                'penerbit' => 'Qisthi Press',
                'tahun_terbit' => 2016,
                'lokasi_rak' => 'A-01',
                'gambar' => 'la-tahzan.jpg',
                'deskripsi' => 'Buku motivasi spiritual yang sangat fenomenal.',
            ],
            [
                'nama' => 'Ringkasan Shahih Bukhari',
                'kategori' => 'agama',
                'pengarang' => 'Imam Al-Bukhari',
                'penerbit' => 'Pustaka Sunnah',
                'tahun_terbit' => 2021,
                'lokasi_rak' => 'A-02',
                'gambar' => 'bukhari.jpg',
                'deskripsi' => 'Kumpulan hadits-hadits sahih untuk pedoman hidup.',
            ],
            [
                'nama' => 'Fiqih Sunnah untuk Wanita',
                'kategori' => 'agama',
                'pengarang' => 'Syaikh Sayyid Sabiq',
                'penerbit' => 'Al-Itishom',
                'tahun_terbit' => 2020,
                'lokasi_rak' => 'A-03',
                'gambar' => 'fiqih-wanita.jpg',
                'deskripsi' => 'Panduan hukum-hukum agama khusus bagi muslimah.',
            ],
        ];

        foreach ($bukus as $buku) {
            $categoryId = $kategoris[$buku['kategori']] ?? null;

            if ($categoryId) {
                Buku::create([
                    'kategori_id' => $categoryId,
                    'nama' => $buku['nama'],
                    'slug' => Str::slug($buku['nama'] . '-' . Str::random(5)),
                    'pengarang' => $buku['pengarang'],
                    'penerbit' => $buku['penerbit'],
                    'tahun_terbit' => $buku['tahun_terbit'],
                    'lokasi_rak' => $buku['lokasi_rak'],
                    'deskripsi' => $buku['deskripsi'],
                    'gambar' => 'books/' . $buku['gambar'],
                    'stok' => rand(5, 50),
                    'is_active' => true,
                    'is_featured' => rand(0, 1),
                ]);
            }
        }

        $this->command->info('Berhasil menginput ' . count($bukus) . ' buku ke database.');
    }
}
