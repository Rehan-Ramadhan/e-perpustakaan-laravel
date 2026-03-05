<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunas = Pengguna::latest()->get();
        return view('admin.pengguna.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastPengguna = Pengguna::latest('id')->first();
        if (!$lastPengguna) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastPengguna->nik;
            $nextNumber = (int) $lastCode + 1;
        }

        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.pengguna.create', compact('otomatisKode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastPengguna = Pengguna::latest('id')->first();
        $nextNumber = (!$lastPengguna) ? 1 : (int) $lastPengguna->nik + 1;
        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Merge ke input NIK
        $request->merge(['nik' => $otomatisKode]);

        $request->validate([
            'nik' => 'required|unique:penggunas,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => 'Nomor pengguna sudah terdaftar.',
        ]);

        Pengguna::create($request->all());

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna baru dengan NIK ' . $otomatisKode . ' berhasil ditambah!')
            ->with('alert-type', 'primary');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penggunas = Pengguna::findOrFail($id);
        return view('admin.pengguna.show', compact('penggunas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penggunas = Pengguna::findOrFail($id);
        return view('admin.pengguna.edit', compact('penggunas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penggunas = Pengguna::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:penggunas,nik,' . $penggunas->nik,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        $penggunas->update($request->all());

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna dengan NIK ' . $penggunas->nik . ' berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penggunas = Pengguna::findOrFail($id);
        $penggunas->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus!')
            ->with('alert-type', 'danger');
    }
}
