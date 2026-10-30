<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, string $role)
{
    if (!$request->user() || $request->user()->role !== $role) {
        abort(403, 'Anda tidak punya akses.');
    }
    return $next($request);
}
}
