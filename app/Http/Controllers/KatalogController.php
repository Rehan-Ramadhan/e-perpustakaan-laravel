<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query()
            ->with(['kategori', 'gambarBukus'])
            ->where('is_active', true);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('pengarang', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $sort = $request->get('sort', 'latest');
        $query->when($sort === 'title_asc', fn($q) => $q->orderBy('nama', 'asc'))
            ->when($sort === 'title_desc', fn($q) => $q->orderBy('nama', 'desc'))
            ->when($sort === 'latest', fn($q) => $q->latest());

        $bukus = $query->paginate(12)->withQueryString();

        $categories = Cache::remember('katalog_categories', 3600, function () {
            return Kategori::where('is_active', true)
                ->withCount(['bukus' => fn($q) => $q->where('is_active', true)])
                ->having('bukus_count', '>', 0)
                ->get();
        });

        return view('katalog.index', compact('bukus', 'categories'));
    }

    public function show($slug)
    {
        $buku = Buku::with(['kategori', 'gambarBukus'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedBukus = Buku::where('kategori_id', $buku->kategori_id)
            ->where('id', '!=', $buku->id)
            ->take(4)
            ->get();

        return view('katalog.show', compact('buku', 'relatedBukus'));
    }
}