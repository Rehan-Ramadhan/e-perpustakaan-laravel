<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migration.
     * Method ini dipanggil saat `php artisan migrate`
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['pengguna', 'admin'])->default('pengguna')->after('password');
            $table->string('avatar')->nullable()->after('role');
            $table->string('google_id')->nullable()->unique()->after('avatar');
            $table->string('telepon', 20)->nullable()->after('google_id');
            $table->text('alamat')->nullable()->after('telepon');
        });
    }

    /**
     * Rollback migration.
     * Method ini dipanggil saat `php artisan migrate:rollback`
     * HARUS kebalikan dari method up() - hapus kolom yang ditambahkan.
     */
    public function down(): void
    {
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'google_id', 'telepon', 'alamat']);
        });
    }
};
