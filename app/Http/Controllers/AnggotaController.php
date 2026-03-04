<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('admin.anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastAnggota = Anggota::latest('id')->first();
        if (!$lastAnggota) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastAnggota->nik;
            $nextNumber = (int) $lastCode + 1;
        }

        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.anggota.create', compact('otomatisKode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastAnggota = Anggota::latest('id')->first();
        $nextNumber = (!$lastAnggota) ? 1 : (int) $lastAnggota->nik + 1;
        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Merge ke input NIK
        $request->merge(['nik' => $otomatisKode]);

        $request->validate([
            'nik' => 'required|unique:anggotas,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => 'Nomor anggota sudah terdaftar.',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota baru dengan NIK ' . $otomatisKode . ' berhasil ditambah!')
            ->with('alert-type', 'primary');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggotas = Anggota::findOrFail($id);
        return view('admin.anggota.show', compact('anggotas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $anggotas = Anggota::findOrFail($id);
        return view('admin.anggota.edit', compact('anggotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggotas = Anggota::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:anggotas,nik,' . $anggotas->nik,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        $anggotas->update($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota dengan NIK ' . $anggotas->nik . ' berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggotas = Anggota::findOrFail($id);
        $anggotas->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus!')
            ->with('alert-type', 'danger');
    }
}
