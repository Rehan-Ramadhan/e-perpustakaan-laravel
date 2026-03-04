<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            // Jika bukan admin, kasih error 403 (Forbidden)
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 3. Jika oke, lanjut ke controller
        return $next($request);
    }
}