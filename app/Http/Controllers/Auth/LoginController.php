<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo(): string
    {
        $user = auth()->user();
        return ($user->role === 'admin') ? '/admin/dashboard' : '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Logika kustom untuk memisahkan pesan error email vs password
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $userExists = User::where($this->username(), $request->{$this->username()})->exists();

        if (!$userExists) {
            $errorMessage = 'Akun belum terdaftar.';
            $errorField = $this->username();
        } else {
            $errorMessage = 'Password salah.';
            $errorField = 'password';
        }

        throw ValidationException::withMessages([
            $errorField => [$errorMessage],
        ]);
    }

    protected function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);
    }
}