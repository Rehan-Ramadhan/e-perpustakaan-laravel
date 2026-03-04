<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Logic Redirect setelah login sukses berdasarkan Role.
     */
    protected function redirectTo(): string
    {
        $user = auth()->user();

        // Jika admin, ke dashboard admin
        if ($user->role === 'admin') {
            return '/admin/dashboard';
        }

        // Jika anggota/pengguna biasa, ke halaman home depan
        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Validasi input login dengan pesan Bahasa Indonesia.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid (harus ada @).',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);
    }
}