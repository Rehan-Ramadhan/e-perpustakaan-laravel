<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained()->cascadeOnDelete();
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->string('pengarang', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->string('lokasi_rak');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->index(['kategori_id', 'is_active']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
