<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastUser = User::latest('id')->first();
        if (!$lastUser) {
            $nextNumber = 1;
        } else {
            $lastCode = $lastUser->nik;
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
        $lastUser = User::latest('id')->first();
        $nextNumber = (!$lastUser) ? 1 : (int) $lastUser->nik + 1;
        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $request->merge(['nik' => $otomatisKode]);

        $request->validate([
            'nik' => 'required|unique:users,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => 'Nomor user sudah terdaftar.',
        ]);

        User::create($request->all());

        return redirect()->route('user.index')
            ->with('success', 'User baru dengan NIK ' . $otomatisKode . ' berhasil ditambah!')
            ->with('alert-type', 'primary')
            ->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);
        $users->load('peminjamans.peminjamanDetail.buku');
        return view('admin.pengguna.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:users,nik,' . $users->nik,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'required' => ':attribute wajib diisi.',
        ]);

        $users->update($request->all());

        return redirect()->route('user.index')
            ->with('success', 'User dengan NIK ' . $users->nik . ' berhasil diperbarui!')
            ->with('alert-type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus!')
            ->with('alert-type', 'danger');
    }
}
