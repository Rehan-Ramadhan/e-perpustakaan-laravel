<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman OAuth Google.
     *
     * Method ini dipanggil ketika user klik tombol "Login dengan Google".
     * Socialite akan membangun URL lengkap dengan semua parameter OAuth.
     *
     * Route: GET /auth/google
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('google')
            // ->stateless() // Opsional: Gunakan jika error "InvalidStateException" terus muncul (bypass session state check)
            ->scopes(['email', 'profile', 'openid'])
            ->redirect();
    }

    /**
     * Handle callback dari Google setelah user memberikan izin.
     *
     * Method ini dipanggil oleh Google setelah user klik "Allow".
     * Google akan mengirimkan authorization_code ke URL ini.
     *
     * Route: GET /auth/google/callback
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        if (request()->has('error')) {
            $error = request('error');

            if ($error === 'access_denied') {
                return redirect()
                    ->route('login')
                    ->with('info', 'Login dengan Google dibatalkan.');
            }

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan: ' . $error);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser);
            Auth::login($user, remember: true);
            session()->regenerate();
            return redirect()
                ->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            logger()->error('Google API Error: ' . $e->getMessage());
            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan saat menghubungi Google. Coba lagi.');

        } catch (Exception $e) {
            logger()->error('OAuth Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Gagal login. Silakan coba lagi.');
        }
    }

    /**
     * Cari user berdasarkan Google ID atau email, atau buat user baru.
     *
     * Method ini menangani 3 skenario:
     * 1. User sudah pernah login dengan Google (ada google_id)
     * 2. User sudah register manual dengan email yang sama
     * 3. User benar-benar baru
     *
     * @param \Laravel\Socialite\Contracts\User $googleUser Data user dari Google
     * @return \App\Models\User User dari database
     */
    protected function findOrCreateUser($googleUser): User
    {
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if ($user->avatar !== $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
            return $user;
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {

            $user->update([
                'google_id' => $googleUser->getId(),

                'avatar' => $googleUser->getAvatar() ?? $user->avatar,

                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            return $user;
        }

        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(24)),
            'role' => 'pengguna',
        ]);
    }
}
