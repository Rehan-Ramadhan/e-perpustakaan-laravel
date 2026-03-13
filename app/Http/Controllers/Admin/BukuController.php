<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        // Gunakan with('kategori') agar tidak N+1 query (sesuai referensi siko)
        $bukus = Buku::with('kategori')->latest()->get();
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        // Logika Auto-Number B001
        $lastBuku = Buku::latest('id')->first();
        $nextNumber = (!$lastBuku) ? 1 : (int) substr($lastBuku->kode_buku, 1) + 1;
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $kategoris = Kategori::all(); // Tambahkan ini untuk dropdown kategori

        return view('admin.buku.create', compact('otomatisKode', 'kategoris'));
    }

    public function store(Request $request)
    {
        // Re-generate kode di sisi server agar aman dari tabrakan data
        $lastBuku = Buku::latest('id')->first();
        $nextNumber = (!$lastBuku) ? 1 : (int) substr($lastBuku->kode_buku, 1) + 1;
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $request->merge([
            'kode_buku' => $otomatisKode,
            'slug' => Str::slug($request->nama) . '-' . time() // Tambahkan slug otomatis
        ]);

        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255', // Sesuaikan kolom migration: nama
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50', // Sesuaikan kolom migration: lokasi_rak
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada.',
            'exists' => 'Kategori tidak valid.',
            'max' => 'Tahun terbit tidak boleh melebihi tahun saat ini.',
        ]);

        Buku::create($request->all());

        return redirect()->route('admin.bukus.index') // Sesuaikan route name
            ->with('success', 'Buku baru [' . $otomatisKode . '] berhasil ditambahkan!')
            ->with('alert-type', 'primary');
    }

    public function show(string $id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        // Update slug jika nama berubah
        $data = $request->all();
        if ($request->nama != $buku->nama) {
            $data['slug'] = Str::slug($request->nama) . '-' . time();
        }

        $buku->update($data);

        return redirect()->route('admin.bukus.index')
            ->with('success', 'Data buku berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.bukus.index')
            ->with('success', 'Buku berhasil dihapus!')
            ->with('alert-type', 'danger');
    }
}
