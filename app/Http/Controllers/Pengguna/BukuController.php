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
        $query = Buku::with(['kategori', 'gambarBukus'])
            ->where('is_active', true);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('pengarang', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $bukus = $query->latest()->paginate(9)->withQueryString();

        $kategoris = Kategori::orderBy('nama')->get();

        return view('user.buku.index', compact('bukus', 'kategoris'));
    }

    public function show($slug)
    {
        $buku = Buku::with(['kategori', 'gambarBukus'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedBukus = Buku::where('kategori_id', $buku->kategori_id)
            ->where('id', '!=', $buku->id)
            ->limit(4)
            ->get();

        return view('user.buku.show', compact('buku', 'relatedBukus'));
    }
}