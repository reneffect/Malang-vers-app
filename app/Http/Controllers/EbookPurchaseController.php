<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Services\EbookAccessService;
use App\Services\EbookPreviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use OutOfBoundsException;

/**
 * EbookPurchaseController
 *
 * Menangani pembelian lisensi satuan, klaim paket standar, dan pembacaan PDF.
 */
class EbookPurchaseController extends Controller
{
    public function __construct(
        private readonly EbookAccessService $accessService,
        private readonly EbookPreviewService $previewService,
    ) {}

    /**
     * Beli lisensi ebook satuan via YoBasePay V4.
     */
    public function purchase(Request $request, Ebook $ebook): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
            }

            return redirect()->route('login');
        }

        try {
            $result = $this->accessService->createEbookPurchaseTransaction($user, $ebook);
            $tx = $result['transaction'];
            $payment = $tx->payment;

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tagihan pembayaran berhasil dibuat. Selesaikan melalui halaman YoBasePay.',
                    'transaction_code' => $tx->transaction_code,
                    'amount' => (float) $tx->total_amount,
                    'amount_to_pay' => $result['gateway']['amount_to_pay'] ?? null,
                    'fee' => $result['gateway']['fee'] ?? null,
                    'fee_payer' => $result['gateway']['fee_payer'] ?? null,
                    'qr_image' => $payment?->qr_code_url,
                    'qr_string' => $payment?->qr_string,
                    'checkout_url' => $payment?->payment_url ?? ($result['gateway']['checkout_url'] ?? $result['gateway']['payment_url'] ?? null),
                    'expired_at' => $payment?->expires_at?->format('Y-m-d H:i:s'),
                    'payment_url' => route('payment.show', $tx->transaction_code),
                ]);
            }

            return redirect()->route('payment.show', $tx->transaction_code);
        } catch (\RuntimeException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }

            return redirect()->route('kamus')->with('error', $e->getMessage());
        }
    }

    /**
     * Klaim 1 ebook gratis dari Paket Standar.
     */
    public function claim(Request $request, Ebook $ebook): JsonResponse
    {
        $user = $request->user();

        try {
            $userEbook = $this->accessService->claimStandarEbook($user, $ebook);

            return response()->json([
                'success' => true,
                'message' => "Ebook \"{$ebook->judul}\" berhasil diklaim! Selamat membaca.",
                'ebook_id' => $ebook->id,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Baca PDF ebook penuh jika memenuhi hak akses.
     */
    public function read(Request $request, Ebook $ebook): mixed
    {
        $user = $request->user();
        $access = $this->accessService->checkAccess($user, $ebook->id);

        if (! $access['can_read']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses tidak tersedia.',
                    'reason' => $access['reason'],
                    'preview_pages' => $access['preview_pages'],
                ], 403);
            }

            return redirect()->route('kamus')
                ->with('error', 'Upgrade paket atau beli lisensi untuk membaca buku ini.');
        }

        $path = $ebook->lokasi_berkas;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function reader(Request $request, Ebook $ebook): RedirectResponse|View
    {
        $access = $this->accessService->checkAccess($request->user(), $ebook->id);

        if ($access['can_read']) {
            return redirect()->route('ebook.read', $ebook);
        }

        return view('member.ebook-reader', [
            'ebook' => $ebook,
            'previewPages' => min(4, max(0, $access['preview_pages'])),
            'currentPage' => max(1, $request->integer('page', 1)),
            'totalPages' => max($ebook->jumlah_halaman ?? 0, $access['preview_pages']),
            'previewAvailable' => filled($ebook->lokasi_berkas)
                && Storage::disk('local')->exists($ebook->lokasi_berkas),
        ]);
    }

    public function previewPage(Request $request, Ebook $ebook, int $page): Response|JsonResponse
    {
        $access = $this->accessService->checkAccess($request->user(), $ebook->id);
        $previewPages = min(4, max(0, $access['preview_pages']));

        if ($access['can_read']) {
            return response()->json([
                'success' => false,
                'message' => 'Gunakan endpoint baca penuh untuk E-Book ini.',
                'read_url' => route('ebook.read', $ebook),
            ], 409);
        }

        if ($page < 1 || $page > $previewPages) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Batas Pratinjau {$previewPages} Halaman Tercapai",
                    'preview_pages' => $previewPages,
                    'purchase_url' => route('ebook.purchase', $ebook),
                ], 403);
            }

            return response()->view('member.ebook-preview-locked', [
                'ebook' => $ebook,
                'previewPages' => $previewPages,
                'previewAvailable' => filled($ebook->lokasi_berkas)
                    && Storage::disk('local')->exists($ebook->lokasi_berkas),
            ], 403);
        }

        if (! $ebook->lokasi_berkas || ! Storage::disk('local')->exists($ebook->lokasi_berkas)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        try {
            $content = $this->previewService->renderPage($ebook, $page);
        } catch (OutOfBoundsException) {
            abort(404, 'Halaman tidak tersedia pada E-Book ini.');
        }

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ebook-'.$ebook->getKey().'-halaman-'.$page.'.pdf"',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Preview cuplikan halaman ebook (maksimal preview_pages).
     */
    public function preview(Request $request, Ebook $ebook): JsonResponse
    {
        $user = $request->user();
        $access = $this->accessService->checkAccess($user, $ebook->id);

        return response()->json([
            'success' => true,
            'can_read_full' => $access['can_read'],
            'preview_pages' => $access['preview_pages'],
            'preview_url' => $access['can_read']
                ? route('ebook.read', $ebook)
                : route('ebook.reader.page', [$ebook, 1]),
            'reason' => $access['reason'],
        ]);
    }
}
