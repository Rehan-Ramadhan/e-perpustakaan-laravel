<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->get();
        return view('buku.index', compact('bukus'));
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

        return view('buku.create', compact('otomatisKode'));
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
            'tahun' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'rak_lokasi' => 'nullable|string|max:50',
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada, gunakan kode lain.',
            'numeric' => 'Input harus berupa angka.',
            'digits' => 'Tahun harus 4 digit (contoh: 2024).',
            'max' => 'Tahun tidak boleh lebih dari tahun sekarang.',
            'min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku ' . $otomatisKode . ' berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku,' . $id,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'rak_lokasi' => 'nullable|string|max:50',
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada, gunakan kode lain.',
            'numeric' => 'Input harus berupa angka.',
            'digits' => 'Tahun harus 4 digit (contoh: 2024).',
            'max' => 'Tahun tidak boleh lebih dari tahun sekarang.',
            'min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku ' . $buku->kode_buku . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
