<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pesanans = Pesanan::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate(['status' => 'required|in:approved,cancelled']);
        
        $oldStatus = $pesanan->status;
        $newStatus = $request->status;

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($pesanan->itemPesanans as $item) {
                $item->buku->increment('stok', 1);
            }
        }

        $pesanan->update(['status' => $newStatus]);

        return back()->with('success', "Status permohonan diperbarui.");
    }
}