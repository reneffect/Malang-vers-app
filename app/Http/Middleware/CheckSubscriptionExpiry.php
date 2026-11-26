<?php

namespace App\Http\Middleware;

use App\Services\MembershipService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckSubscriptionExpiry
 *
 * Otomatis downgrade user kembali ke Paket Gratis
 * jika membership ends_at-nya sudah lewat.
 * Cukup dipasang di grup middleware member.
 */
class CheckSubscriptionExpiry
{
    public function __construct(
        private readonly MembershipService $membershipService,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $this->membershipService->expireStaleSubscriptions($user);
        }

        return $next($request);
    }
}
