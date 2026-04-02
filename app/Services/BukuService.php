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

class BukuService
{
    /**
     * Handle upload multiple gambar untuk buku.
     * Gambar pertama akan otomatis jadi primary jika belum ada primary.
     */
    // app\Services\BukuService.php

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
     * Validasi data buku sebelum disimpan.
     * @throws ValidationException
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

    /**
     * Query dasar dengan fitur pencarian dan filter.
     */
    public function query(array $params = []): Builder
    {
        $query = Buku::with(['kategori', 'primaryImage']);

        if (!empty($params['id'])) {
            $query->where('id', $params['id']);
        }

        if (!empty($params['nama'])) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        if (!empty($params['kategori_id'])) {
            $query->where('kategori_id', $params['kategori_id']);
        }

        if (!empty($params['pengarang'])) {
            $query->where('pengarang', 'like', '%' . $params['pengarang'] . '%');
        }

        if (isset($params['is_active']) && $params['is_active'] !== '') {
            $query->where('is_active', $params['is_active']);
        }

        if (!empty($params['order_by'])) {
            foreach ($params['order_by'] as $key => $direction) {
                $query->orderBy($key, $direction);
            }
        } else {
            $query->latest();
        }

        return $query;
    }

    public function findOne(array $params): ?Buku
    {
        return $this->query($params)->first();
    }

    public function findAll(array $params = []): Collection
    {
        return $this->query($params)->get();
    }

    public function findById(int $id): ?Buku
    {
        return Buku::with('gambarBukus')->find($id);
    }

    public function findWithImages(string $identifier, bool $isSlug = false): ?Buku
    {
        $query = Buku::with(['kategori', 'gambarBukus']);
        if ($isSlug) {
            return $query->where('slug', $identifier)->first();
        }

        return $query->find($identifier);
    }

    public function generateNextCode(): string
    {
        $nextId = ((int) Buku::max('id')) + 1;
        return 'B' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
    }

    public function getKategoriOptions(): Collection
    {
        return Kategori::orderBy('nama')->get();
    }

    /**
     * Simpan buku baru.
     */
    public function create(Buku $model): Buku
    {
        $model->is_active = (bool) ($model->is_active ?? true);
        $model->is_featured = (bool) ($model->is_featured ?? false);

        $this->validate($model);
        $model->save();

        return $model;
    }

    /**
     * Update data buku.
     */
    public function update(Buku $model): Buku
    {
        $model->is_active = (bool) $model->is_active;
        $model->is_featured = (bool) $model->is_featured;

        $this->validate($model);
        $model->save();

        return $model;
    }

    /**
     * Hapus buku beserta file gambarnya.
     */
    public function delete(Buku $model): bool
    {
        foreach ($model->gambarBukus as $gambar) {
            if ($gambar->lokasi_gambar) {
                Storage::disk('public')->delete($gambar->lokasi_gambar);
            }
        }

        return $model->delete();
    }
}