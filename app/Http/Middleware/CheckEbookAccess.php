<?php

namespace App\Http\Middleware;

use App\Services\EbookAccessService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckEbookAccess
 *
 * Pastikan user boleh membaca penuh ebook tertentu.
 * Gunakan di route yang memerlukan akses PDF penuh.
 *
 * Route harus memiliki parameter {ebook} (berupa ID ebook).
 */
class CheckEbookAccess
{
    public function __construct(
        private readonly EbookAccessService $accessService,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $ebook = $request->route('ebook');
        $user  = $request->user();

        if (! $ebook) {
            return $next($request);
        }

        $ebookId = is_object($ebook) ? $ebook->id : (int) $ebook;
        $access  = $this->accessService->checkAccess($user, $ebookId);

        if (! $access['can_read']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success'       => false,
                    'message'       => 'Akses baca penuh tidak tersedia. Silakan upgrade paket atau beli lisensi.',
                    'reason'        => $access['reason'],
                    'preview_pages' => $access['preview_pages'],
                ], 403);
            }

            return redirect()->route('kamus')
                ->with('error', 'Upgrade paket atau beli lisensi untuk membaca buku ini secara penuh.');
        }

        return $next($request);
    }
}
