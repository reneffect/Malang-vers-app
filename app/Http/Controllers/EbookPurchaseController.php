<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\UserEbook;
use App\Services\EbookAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * EbookPurchaseController
 *
 * Menangani pembelian lisensi satuan, klaim paket standar, dan pembacaan PDF.
 */
class EbookPurchaseController extends Controller
{
    public function __construct(
        private readonly EbookAccessService $accessService,
    ) {}

    /**
     * Beli lisensi ebook satuan via QRIS YoBasePay V4.
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
            $tx      = $result['transaction'];
            $payment = $tx->payment;

            if ($request->expectsJson()) {
                return response()->json([
                    'success'          => true,
                    'message'          => 'Tagihan QRIS berhasil dibuat. Silakan scan untuk menyelesaikan pembayaran.',
                    'transaction_code' => $tx->transaction_code,
                    'amount'           => (float) $tx->total_amount,
                    'qr_image'         => $payment?->qr_code_url,
                    'qr_string'        => $payment?->qr_string,
                    'expired_at'       => $payment?->expires_at?->format('Y-m-d H:i:s'),
                    'payment_url'      => route('payment.show', $tx->transaction_code),
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
                'success'  => true,
                'message'  => "Ebook \"{$ebook->judul}\" berhasil diklaim! Selamat membaca.",
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
        $user   = $request->user();
        $access = $this->accessService->checkAccess($user, $ebook->id);

        if (! $access['can_read']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success'       => false,
                    'message'       => 'Akses tidak tersedia.',
                    'reason'        => $access['reason'],
                    'preview_pages' => $access['preview_pages'],
                ], 403);
            }

            return redirect()->route('kamus')
                ->with('error', 'Upgrade paket atau beli lisensi untuk membaca buku ini.');
        }

        $path = $ebook->lokasi_berkas;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $fileContent = Storage::disk('public')->get($path);

        return response($fileContent, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    /**
     * Preview cuplikan halaman ebook (maksimal preview_pages).
     */
    public function preview(Request $request, Ebook $ebook): JsonResponse
    {
        $user   = $request->user();
        $access = $this->accessService->checkAccess($user, $ebook->id);

        $previewPath = $ebook->lokasi_pratinjau;

        return response()->json([
            'success'       => true,
            'can_read_full' => $access['can_read'],
            'preview_pages' => $access['preview_pages'],
            'preview_url'   => $previewPath ? Storage::disk('public')->url($previewPath) : null,
            'reason'        => $access['reason'],
        ]);
    }
}
