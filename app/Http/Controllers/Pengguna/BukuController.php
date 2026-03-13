<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan buku yang aktif, dipaginasi 6 per halaman
        $bukus = Buku::with('kategori')
            ->where('is_active', true)
            ->when($request->kategori, function ($query) use ($request) {
                $query->whereHas('kategori', function ($q) use ($request) {
                    $q->where('slug', $request->kategori);
                });
            })
            ->latest()
            ->paginate(6);

        $kategoris = Kategori::all();

        return view('pengguna.buku.index', compact('bukus', 'kategoris'));
    }

    public function show($slug)
    {
        $buku = Buku::with(['kategori', 'gambarBukus'])->where('slug', $slug)->firstOrFail();
        return view('pengguna.buku.show', compact('buku'));
    }
}
