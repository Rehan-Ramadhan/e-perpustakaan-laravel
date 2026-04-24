<?php

namespace App\Http\Controllers;

use App\Services\PesananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $pesananService;

    public function __construct(PesananService $pesananService)
    {
        $this->pesananService = $pesananService;
    }

    public function index()
    {
        $keranjang = Auth::user()->keranjang()->with('itemKeranjangs.buku')->first();

        if (!$keranjang || $keranjang->itemKeranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        return view('checkout.index', compact('keranjang'));
    }

    public function store(Request $request)
    {
        try {
            $pesanan = $this->pesananService->buatPesanan(Auth::user());

            return redirect()->route('katalog.index')
                ->with('success', 'Berhasil! Pesanan ' . $pesanan->kode_pesanan . ' sedang menunggu konfirmasi admin.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}