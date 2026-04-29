<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login DAN role-nya adalah 'admin', silakan lewat
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tolak dengan error 403
        abort(403, 'Akses Ditolak. Halaman ini khusus Administrator.');
    }
}