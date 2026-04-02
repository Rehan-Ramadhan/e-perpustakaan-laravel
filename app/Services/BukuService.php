<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\GambarBuku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class BukuService
{
    /**
     * Handle upload multiple gambar untuk buku.
     */
    public function uploadImages(array $files, Buku $buku): void
    {
        if (count($files) > 0) {
            foreach ($buku->gambarBukus as $gambar) {
                if ($gambar->lokasi_gambar) {
                    Storage::disk('public')->delete($gambar->lokasi_gambar);
                }
                $gambar->delete();
            }

            foreach ($files as $index => $file) {
                $filename = 'buku-' . $buku->id . '-' . time() . '-' . $index . '.' . $file->extension();
                $path = $file->storeAs('buku', $filename, 'public');

                $buku->gambarBukus()->create([
                    'lokasi_gambar' => $path,
                    'is_primary' => $index === 0,
                    'urutan' => $index,
                ]);
            }
        }
    }

    /**
     * Validasi data buku (Validasi Custom Akang).
     */
    public function validate(Buku $model): void
    {
        $validator = Validator::make($model->toArray(), [
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:100',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute tidak valid.',
            'max' => ':attribute terlalu panjang.',
            'min' => ':attribute terlalu kecil.',
        ], [
            'kategori_id' => 'Kategori',
            'nama' => 'Judul Buku',
            'pengarang' => 'Pengarang',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
            'stok' => 'Stok',
            'lokasi_rak' => 'Lokasi Rak',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function create(Buku $model): Buku
    {
        $model->is_active = (bool) ($model->is_active ?? true);
        $model->is_featured = (bool) ($model->is_featured ?? false);
        $this->validate($model);
        $model->save();
        return $model;
    }

    public function update(Buku $model): Buku
    {
        $model->is_active = (bool) $model->is_active;
        $model->is_featured = (bool) $model->is_featured;
        $this->validate($model);
        $model->save();
        return $model;
    }

    public function delete(Buku $model): bool
    {
        foreach ($model->gambarBukus as $gambar) {
            if ($gambar->lokasi_gambar) {
                Storage::disk('public')->delete($gambar->lokasi_gambar);
            }
        }
        return $model->delete();
    }

    public function generateNextCode(): string
    {
        $nextId = ((int) Buku::max('id')) + 1;
        return 'B' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
    }
}