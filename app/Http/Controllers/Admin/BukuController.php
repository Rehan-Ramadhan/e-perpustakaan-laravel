<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Services\BukuService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BukuController extends Controller
{
    public function __construct(private readonly BukuService $bukuService)
    {
    }

    public function index()
    {
        return view('admin.buku.index', [
            'bukus' => $this->bukuService->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin.buku.create', [
            'otomatisKode' => $this->bukuService->generateNextCode(),
            'kategoris' => $this->bukuService->getKategoriOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $buku = new Buku();
        $buku->fill($request->all());
        $buku->is_active = $request->boolean('is_active');

        try {
            $this->bukuService->create($buku);

            return redirect()
                ->route('admin.buku.index')
                ->with('success', 'Buku baru [' . $buku->kode_buku . '] berhasil ditambahkan.')
                ->with('alert-type', 'primary');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data buku gagal disimpan. Periksa kembali isian form.');
        }
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');

        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', [
            'buku' => $buku,
            'kategoris' => $this->bukuService->getKategoriOptions(),
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $buku->fill($request->all());
        $buku->is_active = $request->boolean('is_active');

        try {
            $this->bukuService->update($buku);

            return redirect()
                ->route('admin.buku.index')
                ->with('success', 'Data buku berhasil diperbarui.')
                ->with('alert-type', 'warning');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data buku gagal diperbarui. Periksa kembali isian form.');
        }
    }

    public function destroy(Buku $buku)
    {
        $kodeBuku = $buku->kode_buku;
        $this->bukuService->delete($buku);

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku [' . $kodeBuku . '] berhasil dihapus.')
            ->with('alert-type', 'danger');
    }
}