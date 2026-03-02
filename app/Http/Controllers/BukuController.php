<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // 1. Menampilkan daftar buku
    public function index()
    {
        $bukus = Buku::all();
        // return view('buku.index', compact('bukus'));
    }

    // 2. Menampilkan form tambah buku
    public function create()
    {
        // return view('buku.create');
    }

    // 3. Menyimpan data buku baru
    public function store(Request $request)
    {
        $$request->validate([
            'kode_buku' => 'required|string|max:20|unique:bukus,kode_buku',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'rak_lokasi' => 'nullable|string|max:50',
        ], [
            // Custom pesan error bahasa Indonesia
            'required' => ':attribute wajib diisi!',
            'unique' => 'Kode buku ini sudah ada,.',
            'numeric' => 'Isi pakai angka saja di bagian :attribute.',
            'max' => 'Tahun tidak boleh lebih dari tahun sekarang.',
            'min' => 'Stok tidak boleh minus.',
        ]);

        Buku::create($request->all());

        // return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
