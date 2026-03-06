<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeding database...');

        $this->call([
            DummyDataSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Administrator Perpustakaan',
            'email' => 'admin@eperpus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Akun Admin berhasil dibuat: admin@eperpus.com');

        User::factory()->create([
            'name' => 'Pengguna',
            'email' => 'pengguna@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pengguna',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Akun Pengguna berhasil dibuat: pengguna@gmail.com');

        $this->command->newLine();
        $this->command->info('Seeding database selesai!');
        $this->command->info('Login Admin   : admin@eperpus.com / password');
        $this->command->info('Login Pengguna : pengguna@gmail.com / password');
    }
}