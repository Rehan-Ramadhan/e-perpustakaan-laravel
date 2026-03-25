<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BukuService
{
    /**
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
            'is_active' => 'nullable|boolean',
        ], [], [
            'kategori_id' => 'Kategori',
            'nama' => 'Judul Buku',
            'pengarang' => 'Pengarang',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
            'stok' => 'Stok',
            'lokasi_rak' => 'Lokasi Rak',
            'deskripsi' => 'Deskripsi',
            'is_active' => 'Status Aktif',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function query(array $params = []): Builder
    {
        $query = Buku::with('kategori');

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
        return $this->findOne(['id' => $id]);
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
     * @throws ValidationException
     */
    public function create(Buku $model): Buku
    {
        $model->is_active = (bool) $model->is_active;
        $this->validate($model);
        $model->save();

        return $model;
    }

    /**
     * @throws ValidationException
     */
    public function update(Buku $model): Buku
    {
        $model->is_active = (bool) $model->is_active;
        $this->validate($model);
        $model->save();

        return $model;
    }

    public function delete(Buku $model): bool
    {
        return $model->delete();
    }
}
