<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Services\BukuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

            $this->bukuService->validate($buku);

            $request->validate([
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'images.required' => 'Minimal 1 gambar wajib diupload.',
                'images.min' => 'Minimal 1 gambar wajib diupload.',
                'images.*.image' => 'File harus berupa gambar.',
                'images.*.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
                'images.*.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            $this->bukuService->create($buku);

            if ($request->hasFile('images')) {
                $this->bukuService->uploadImages($request->file('images'), $buku);
            }

            DB::commit();

            return redirect()
                ->route('admin.buku.index')
                ->with('success', 'Buku baru [' . $buku->kode_buku . '] berhasil ditambahkan.')
                ->with('alert-type', 'primary');

        } catch (ValidationException $e) {
            DB::rollBack();

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data buku gagal disimpan. Periksa kembali isian form.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data buku.');
        }
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'gambarBukus', 'activities']);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $buku->load('gambarBukus');

        return view('admin.buku.edit', [
            'buku' => $buku,
            'kategoris' => Kategori::all(),
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        try {
            DB::beginTransaction();

            $buku->fill($request->all());
            $buku->is_active = $request->boolean('is_active');

            $this->bukuService->validate($buku);

            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'images.*.image' => 'File harus berupa gambar.',
                'images.*.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
                'images.*.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            $this->bukuService->update($buku);

            if ($request->hasFile('images')) {
                $this->bukuService->uploadImages($request->file('images'), $buku);
            }

            DB::commit();

            return redirect()
                ->route('admin.buku.index')
                ->with('success', 'Data buku berhasil diperbarui.')
                ->with('alert-type', 'warning');

        } catch (ValidationException $e) {
            DB::rollBack();

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data buku gagal diperbarui. Periksa kembali isian form.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data buku.');
        }
    }

    public function destroy(Buku $buku)
    {
        try {
            $kode = $buku->kode_buku;

            $this->bukuService->delete($buku);

            return redirect()
                ->route('admin.buku.index')
                ->with('success', 'Buku [' . $kode . '] berhasil dihapus.')
                ->with('alert-type', 'danger');

        } catch (\Exception $e) {
            return back()->with('error', 'Data buku gagal dihapus.');
        }
    }
}