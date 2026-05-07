<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Services\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Auth::user()->pesanans()
            ->with('itemPesanans.buku')
            ->latest()
            ->paginate(10);

        return view('pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pesanan.show', compact('pesanan'));
    }

    public function batal(Pesanan $pesanan, PesananService $pesananService)
    {
        return $pesananService->batal($pesanan);
    }
}