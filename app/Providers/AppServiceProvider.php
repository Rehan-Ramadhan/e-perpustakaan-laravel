<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;
use App\Models\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('bagian.navbar', function ($view) {
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

            $totalItemKeranjang = 0;
            if (auth()->check()) {
                $keranjang = Keranjang::where('user_id', auth()->id())->withCount('items')->first();
                $totalItemKeranjang = $keranjang ? $keranjang->items_count : 0;
            }

            $keinginanCount = 0;

            if (auth()->check()) {
                $keranjang = Keranjang::where('user_id', auth()->id())->withCount('items')->first();
                $totalItemKeranjang = $keranjang ? $keranjang->items_count : 0;

                $keinginanCount = auth()->user()->keinginans()->count();
            }

            $view->with([
                'kategori' => $kategori,
                'totalItemKeranjang' => $totalItemKeranjang,
                'keinginanCount' => $keinginanCount
            ]);
        });
    }
}