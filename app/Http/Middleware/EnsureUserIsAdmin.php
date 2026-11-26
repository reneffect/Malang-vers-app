<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login DAN role-nya adalah 'admin'
        if (! $request->user() || $request->user()->role !== 'admin') {
            // Jika bukan admin, tendang ke halaman home atau tampilkan error 403
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Administrator.');
        }

        return $next($request);
    }
}
