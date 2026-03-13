<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Memulai pengiriman database...');

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@eperpustakaan.com',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::factory(15)->create([
            'role' => 'pengguna'
        ]);

        User::factory()->create([
            'name' => 'Tes',
            'email' => 'tes@gmail.com',
            'role' => 'pengguna',
            'password' => bcrypt('password'),
        ]);

        $this->command->info('User Admin & 15+ Pengguna berhasil dibuat.');

        $this->call([
            KategoriSeeder::class,
            BukuSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('Pengisian database selesai!');
        $this->command->info('Admin: admin@eperpustakaan.com / password');
        $this->command->info('User: tes@gmail.com / password');
    }
}