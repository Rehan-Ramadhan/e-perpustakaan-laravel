<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::withCount('bukus')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'nama' => 'required|string|max:100|unique:kategoris,nama',
                'deskripsi' => 'nullable|string|max:500',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('kategori', 'public');
            }

            $validated['slug'] = Str::slug($validated['nama']);
            $validated['is_active'] = $request->boolean('is_active');

            Kategori::create($validated);

            DB::commit();
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil disimpan.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Kategori $kategori)
    {
        $kategori->load('bukus');
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'nama' => 'required|string|max:100|unique:kategoris,nama,' . $kategori->id,
                'deskripsi' => 'nullable|string|max:500',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                if ($kategori->gambar && Storage::disk('public')->exists($kategori->gambar)) {
                    Storage::disk('public')->delete($kategori->gambar);
                }

                $validated['gambar'] = $request->file('gambar')->store('kategori', 'public');
            }

            $validated['slug'] = Str::slug($validated['nama']);
            $validated['is_active'] = $request->boolean('is_active');

            $kategori->update($validated);

            DB::commit();
            return redirect()->route('admin.kategori.index')->with('success', 'Kategori diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->bukus()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki data buku.');
        }

        if ($kategori->gambar && Storage::disk('public')->exists($kategori->gambar)) {
            Storage::disk('public')->delete($kategori->gambar);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori dihapus.');
    }
}