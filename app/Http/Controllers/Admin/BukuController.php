<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Services\BukuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class BukuController extends Controller
{
    public function __construct(private readonly BukuService $bukuService)
    {
    }

    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('kode_buku', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('admin.buku.create', [
            'otomatisKode' => $this->bukuService->generateNextCode(),
            'kategoris' => Kategori::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $buku = new Buku();
            $buku->fill($request->all());
            $buku->is_active = $request->boolean('is_active');

            $request->validate([
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $this->bukuService->create($buku);

            if ($request->hasFile('images')) {
                $this->bukuService->uploadImages($request->file('images'), $buku);
            }

            DB::commit();
            return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'gambarBukus', 'activities']);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        try {
            DB::beginTransaction();
            $buku->fill($request->all());
            $buku->is_active = $request->boolean('is_active');

            $this->bukuService->update($buku);

            if ($request->hasFile('images')) {
                $this->bukuService->uploadImages($request->file('images'), $buku);
            }

            DB::commit();
            return redirect()->route('admin.buku.index')->with('success', 'Buku diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Buku $buku)
    {
        $this->bukuService->delete($buku);
        return redirect()->route('admin.buku.index')->with('success', 'Buku dihapus.');
    }
}