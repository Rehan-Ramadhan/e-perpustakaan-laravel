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
        Schema::create('gambar_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained()->cascadeOnDelete();
            $table->string('lokasi_gambar');
            $table->boolean('is_primary')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->index(['buku_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_bukus');
    }
};
