<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KeinginanController extends Controller
{
    /**
     * Menampilkan daftar buku yang disukai pengguna.
     */
    public function index()
    {
        $bukus = auth()->user()->keinginan()
            ->with(['kategori', 'gambarBukus'])
            ->latest('keinginans.created_at')
            ->paginate(12);

        return view('keinginan.index', compact('bukus'));
    }

    /**
     * Menangani tambah/hapus daftar suka via AJAX.
     */
    public function toggle(Buku $buku)
    {
        $user = auth()->user();

        if ($user->hasInKeinginan($buku)) {
            $user->keinginans()->detach($buku->id);
            $added = false;
            $message = 'Buku dihapus dari daftar suka.';
        } else {
            $user->keinginans()->attach($buku->id);
            $added = true;
            $message = 'Buku ditambahkan ke daftar suka!';
        }

        return response()->json([
            'status' => 'success',
            'added' => $added,
            'message' => $message,
            'count' => $user->keinginans()->count()
        ]);
    }
}