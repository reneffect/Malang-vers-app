<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Jika belum login, lempar ke halaman login admin
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // 2. Jika sudah login tapi role-nya bukan 'admin', tolak akses
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus admin.');
        }

        // 3. Jika admin, lanjutkan request
        return $next($request);
    }
}