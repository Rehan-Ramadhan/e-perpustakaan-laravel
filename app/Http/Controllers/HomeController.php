<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Kategori::query()
            ->where('is_active', true)
            ->withCount([
                'bukus' => function ($q) {
                    $q->where('is_active', true)
                        ->where('stok', '>', 0);
                }
            ])
            ->having('bukus_count', '>', 0)
            ->orderBy('nama')
            ->take(6)
            ->get();

        $featuredBooks = Buku::query()
            ->with(['kategori'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $latestBooks = Buku::query()
            ->with(['kategori'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact(
            'categories',
            'featuredBooks',
            'latestBooks'
        ));
    }
}
