<?php

namespace App\Http\Controllers;

use App\Services\KeranjangService;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    protected $keranjangService;

    // Inject Service
    public function __construct(KeranjangService $keranjangService)
    {
        $this->keranjangService = $keranjangService;
    }

    public function index()
    {
        $items = $this->keranjangService->getItems();
        $totalBuku = $items->sum('jumlah');

        return view('keranjang.index', compact('items', 'totalBuku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        try {
            $this->keranjangService->addBuku($request->buku_id, $request->jumlah);
            return back()->with('success', 'Buku berhasil dimasukkan ke daftar pinjam.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        try {
            $this->keranjangService->updateJumlah($id, $request->jumlah);
            return back()->with('success', 'Jumlah buku diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->keranjangService->removeItem($id);
            return back()->with('success', 'Buku dihapus dari daftar.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus item.');
        }
    }
}