<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->get();
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $lastBuku = Buku::latest('id')->first();
        if (!$lastBuku) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastBuku->kode_buku;
            $nextNumber = (int) substr($lastCode, 1) + 1;
        }
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.buku.create', compact('otomatisKode'));
    }

    public function store(Request $request)
    {
        $lastBuku = Buku::latest('id')->first();
        $nextNumber = (!$lastBuku) ? 1 : (int) substr($lastBuku->kode_buku, 1) + 1;
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $request->merge(['kode_buku' => $otomatisKode]);

        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'rak_lokasi' => 'nullable|string|max:50',
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada, gunakan kode lain.',
            'numeric' => 'Input harus berupa angka.',
            'digits' => 'Tahun_terbit harus 4 digit (contoh: 2024).',
            'max' => 'Tahun_terbit tidak boleh lebih dari tahun_terbit sekarang.',
            'min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku baru dengan kode ' . $otomatisKode . ' berhasil ditambahkan!')
            ->with('alert-type', 'primary')
            ->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bukus = Buku::findOrFail($id);
        return view('admin.buku.show', compact('bukus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bukus = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bukus = Buku::findOrFail($id);

        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku,' . $bukus->id,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'rak_lokasi' => 'nullable|string|max:50',
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada, gunakan kode lain.',
            'numeric' => 'Input harus berupa angka.',
            'digits' => 'Tahun harus 4 digit (contoh: 2008).',
            'max' => 'Tahun tidak boleh lebih dari tahun sekarang.',
            'min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        $bukus->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku ' . $bukus->kode_buku . ' berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bukus = Buku::findOrFail($id);
        $bukus->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!')
            ->with('alert-type', 'danger');
    }
}
