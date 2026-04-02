<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * @throws ValidationException
     */
    public function validate(array $data, int $userId = null): void
    {
        $nikRule = 'required|unique:users,nik';
        if ($userId) {
            $nikRule .= ',' . $userId;
        }

        $validator = Validator::make($data, [
            'nik' => $nikRule,
            'name' => 'required|string|max:255',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            'numeric' => ':attribute harus berupa angka.',
        ], [
            'nik' => 'NIK',
            'name' => 'Nama',
            'telepon' => 'Telepon',
            'alamat' => 'Alamat',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function findAll(): Collection
    {
        return User::latest()->get();
    }

    public function generateNextNik(): string
    {
        $lastUser = User::latest('id')->first();
        $nextNumber = !$lastUser ? 1 : (int) $lastUser->nik + 1;
        return str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * @throws ValidationException
     */
    public function create(array $data): User
    {
        $data['nik'] = $this->generateNextNik();
        $data['email'] = $data['email'] ?? $data['nik'] . '@eperpus.com';
        $data['password'] = bcrypt($data['password'] ?? 'password123');
        $data['role'] = 'pengguna';

        $this->validate($data);

        return User::create($data);
    }

    /**
     * @throws ValidationException
     */
    public function update(User $user, array $data): bool
    {
        $this->validate($data, $user->id);
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}