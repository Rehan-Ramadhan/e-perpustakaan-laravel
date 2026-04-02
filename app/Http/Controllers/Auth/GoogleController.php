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
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->scopes(['email', 'profile', 'openid'])
            ->redirect();
    }

    /**
     * Handle callback dari Google setelah user memberikan izin.
     */
    public function callback()
    {
        if (request()->has('error')) {
            $error = request('error');
            if ($error === 'access_denied') {
                return redirect()->route('login')->with('info', 'Login dengan Google dibatalkan.');
            }
            return redirect()->route('login')->with('error', 'Terjadi kesalahan: ' . $error);
        }

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = $this->findOrCreateUser($googleUser);

            Auth::login($user, remember: true);
            session()->regenerate();

            return redirect()->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Session telah berakhir. Silakan coba lagi.');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            logger()->error('Google API Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat menghubungi Google.');
        } catch (Exception $e) {
            logger()->error('OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal login. Silakan coba lagi.');
        }
    }

    /**
     * Cari user berdasarkan Google ID atau email, atau buat user baru.
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
            'nik' => 'G-' . strtoupper(Str::random(10)),
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