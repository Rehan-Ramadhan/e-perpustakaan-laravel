<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function create()
    {
        $lastUser = User::latest('id')->first();
        $nextNumber = !$lastUser ? 1 : (int) $lastUser->nik + 1;
        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.user.create', compact('otomatisKode'));
    }

    public function store(Request $request)
    {
        $lastUser = User::latest('id')->first();
        $nextNumber = !$lastUser ? 1 : (int) $lastUser->nik + 1;
        $otomatisKode = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $request->merge(['nik' => $otomatisKode]);

        try {
            $request->validate([
                'nik' => 'required|unique:users,nik',
                'name' => 'required|string|max:255',
                'telepon' => 'required|numeric',
                'alamat' => 'required|string',
            ], [
                'required' => ':attribute wajib diisi.',
                'unique' => 'Nomor user sudah terdaftar.',
            ]);

            User::create($request->all());

            return redirect()
                ->route('admin.pengguna.index')
                ->with('success', 'User baru [' . $otomatisKode . '] berhasil ditambahkan.')
                ->with('alert-type', 'primary');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data user gagal disimpan. Periksa kembali isian form.');
        }
    }

    public function show(User $user)
    {
        $user->load('peminjamans.peminjamanDetail.buku');

        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'nik' => 'required|unique:users,nik,' . $user->id,
                'name' => 'required|string|max:255',
                'alamat' => 'required|string',
                'telepon' => 'required|numeric',
            ], [
                'required' => ':attribute wajib diisi.',
            ]);

            $user->update($request->all());

            return redirect()
                ->route('admin.pengguna.index')
                ->with('success', 'Data user berhasil diperbarui.')
                ->with('alert-type', 'warning');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data user gagal diperbarui. Periksa kembali isian form.');
        }
    }

    public function destroy(User $user)
    {
        $nik = $user->nik;
        $user->delete();

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'User [' . $nik . '] berhasil dihapus.')
            ->with('alert-type', 'danger');
    }
}