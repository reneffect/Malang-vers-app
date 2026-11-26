<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMember
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login DAN role-nya adalah 'member' (atau 'user', sesuaikan dengan DB)
        if (! $request->user() || $request->user()->role !== 'member') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Member.');
        }

        return $next($request);
    }
}
