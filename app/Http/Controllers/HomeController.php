<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kategori = Kategori::query()
            ->where('is_active', true)
            ->withCount([
                'bukus' => function ($q) {
                    $q->where('is_active', true)->where('stok', '>', 0);
                }
            ])
            ->having('bukus_count', '>', 0)
            ->orderBy('nama')
            ->get();

        $bukuUnggulan = Buku::query()
            ->with(['kategori', 'gambarBukus'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(10)
            ->get();

        $bukuTerbaru = Buku::query()
            ->with(['kategori', 'gambarBukus'])
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        return view('home', compact('kategori', 'bukuUnggulan', 'bukuTerbaru'));
    }
}
