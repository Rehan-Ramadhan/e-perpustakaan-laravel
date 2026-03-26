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
<<<<<<< HEAD
        $bukus = Buku::with('kategori')->latest()->get();
        return view('admin.buku.index', compact('bukus'));
=======
        return view('admin.buku.index', [
            'bukus' => $this->bukuService->findAll(),
        ]);
>>>>>>> c9a14896f98e5cb0d4dca4b087f82a34753c3b6f
    }

    public function create()
    {
<<<<<<< HEAD
        $lastBuku = Buku::latest('id')->first();
        $nextNumber = (!$lastBuku) ? 1 : (int) substr($lastBuku->kode_buku, 1) + 1;
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $kategoris = Kategori::all();

        return view('admin.buku.create', compact('otomatisKode', 'kategoris'));
=======
        return view('admin.buku.create', [
            'otomatisKode' => $this->bukuService->generateNextCode(),
            'kategoris' => $this->bukuService->getKategoriOptions(),
        ]);
>>>>>>> c9a14896f98e5cb0d4dca4b087f82a34753c3b6f
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        $lastBuku = Buku::latest('id')->first();
        $nextNumber = (!$lastBuku) ? 1 : (int) substr($lastBuku->kode_buku, 1) + 1;
        $otomatisKode = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $request->merge([
            'kode_buku' => $otomatisKode,
            'slug' => Str::slug($request->nama) . '-' . time()
        ]);

        $request->validate([
            'kode_buku' => 'required|unique:bukus,kode_buku',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ], [
            'required' => ':attribute wajib diisi, jangan dikosongkan.',
            'unique' => 'Kode buku sudah ada.',
            'exists' => 'Kategori tidak valid.',
            'max' => 'Tahun terbit tidak boleh melebihi tahun saat ini.',
        ]);

        Buku::create($request->all());

        return redirect()->route('admin.bukus.index')
            ->with('success', 'Buku baru [' . $otomatisKode . '] berhasil ditambahkan!')
            ->with('alert-type', 'primary');
=======
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
>>>>>>> c9a14896f98e5cb0d4dca4b087f82a34753c3b6f
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
<<<<<<< HEAD

        $data = $request->all();
        if ($request->nama != $buku->nama) {
            $data['slug'] = Str::slug($request->nama) . '-' . time();
        }

        $buku->update($data);

        return redirect()->route('admin.bukus.index')
            ->with('success', 'Data buku berhasil diperbarui!')
            ->with('alert-type', 'warning');
=======
>>>>>>> c9a14896f98e5cb0d4dca4b087f82a34753c3b6f
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
