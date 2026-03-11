<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // app/Http/Middleware/AdminMiddleware.php

        if (Auth::check() && Auth::user()->role == 'admin' && Auth::user()->status == 'aktif') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Area itu khusus Admin yang aktif.');
    }
}