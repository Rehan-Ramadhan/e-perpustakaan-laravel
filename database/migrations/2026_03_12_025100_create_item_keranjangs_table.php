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
        Schema::create('item_keranjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keranjang_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buku_id')->constrained()->cascadeOnDelete();
            $table->integer('kuantitas')->default(1);
            $table->timestamps();
            $table->unique(['keranjang_id', 'buku_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjangs');
    }
};
