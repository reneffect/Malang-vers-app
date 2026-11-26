<?php

namespace App\Services;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\UserEbook;
use Illuminate\Support\Facades\DB;

/**
 * EbookAccessService
 *
 * Mengelola akses baca E-Book:
 *  - Premium aktif → akses SEMUA buku
 *  - Punya lisensi satuan (purchased) → akses buku itu
 *  - Punya klaim Standar (claimed) → akses buku itu
 *  - Pembelian lisensi satuan via QRIS YoBasePay V4
 */
class EbookAccessService
{
    public function __construct(
        private readonly YoBasePayService $yoBasePayService,
    ) {}

    /**
     * Cek apakah user boleh membaca penuh ebook tertentu.
     *
     * @return array{can_read: bool, reason: string, preview_pages: int}
     */
    public function checkAccess(?User $user, int $ebookId): array
    {
        if (! $user) {
            return [
                'can_read'      => false,
                'reason'        => 'NOT_LOGGED_IN',
                'preview_pages' => 5,
            ];
        }

        if ($user->isPremium()) {
            return [
                'can_read'      => true,
                'reason'        => 'PREMIUM',
                'preview_pages' => 0,
            ];
        }

        if ($user->canAccessEbook($ebookId)) {
            return [
                'can_read'      => true,
                'reason'        => 'OWNED',
                'preview_pages' => 0,
            ];
        }

        $plan         = $user->getActivePlan();
        $previewPages = $plan?->preview_pages ?? 5;

        return [
            'can_read'      => false,
            'reason'        => 'NO_ACCESS',
            'preview_pages' => $previewPages,
        ];
    }

    /**
     * Proses pembuatan pesanan lisensi ebook satuan via QRIS YoBasePay.
     *
     * @throws \RuntimeException jika user sudah punya ebook ini
     */
    public function createEbookPurchaseTransaction(User $user, Ebook $ebook): array
    {
        // Cek apakah user sudah punya akses
        if ($user->canAccessEbook($ebook->id)) {
            throw new \RuntimeException('Kamu sudah memiliki lisensi atau akses ke ebook ini.');
        }

        $price = (float) ($ebook->harga_lisensi > 0 ? $ebook->harga_lisensi : $ebook->harga);

        if ($price < 10000) {
            // Standar minimal QRIS SQ adalah 10.000
            $price = 10000;
        }

        return DB::transaction(function () use ($user, $ebook, $price) {
            // 1. Buat record transaksi utama
            $transaction = Transaction::create([
                'user_id'          => $user->id,
                'transaction_code' => Transaction::generateCode(),
                'total_amount'     => $price,
                'status'           => 'pending',
                'expires_at'       => now()->addMinutes(15),
            ]);

            // 2. Buat snapshot item transaksi
            TransactionItem::create([
                'transaction_id'     => $transaction->id,
                'item_type'          => 'ebook',
                'ebook_id'           => $ebook->id,
                'item_name_snapshot' => $ebook->judul,
                'quantity'           => 1,
                'unit_price'         => $price,
                'subtotal'           => $price,
            ]);

            // 3. Request QRIS ke YoBasePay V4 (Channel SQ)
            $qrisData = $this->yoBasePayService->createQrisPayment($transaction, $user);

            return [
                'transaction' => $transaction->fresh(['payment', 'items']),
                'ebook'       => $ebook,
                'qris'        => $qrisData,
            ];
        });
    }

    /**
     * Proses klaim 1 ebook gratis dari Paket Standar.
     */
    public function claimStandarEbook(User $user, Ebook $ebook): UserEbook
    {
        return DB::transaction(function () use ($user, $ebook) {
            $membership = Membership::where('user_id', $user->id)
                ->active()
                ->whereHas('tier', fn ($q) => $q->where('slug', 'standar'))
                ->lockForUpdate()
                ->first();

            if (! $membership) {
                throw new \RuntimeException('Kamu tidak memiliki Paket Standar aktif.');
            }

            $tier         = $membership->tier;
            $claimLimit   = $tier?->claimable_ebooks ?? 1;
            $claimedCount = UserEbook::where('user_id', $user->id)
                ->where('acquisition_type', 'claimed')
                ->where('membership_id', $membership->id)
                ->count();

            if ($claimedCount >= $claimLimit) {
                throw new \RuntimeException("Kamu sudah menggunakan {$claimLimit} klaim ebook dari Paket Standar.");
            }

            if (! $ebook->can_be_claimed) {
                throw new \RuntimeException('Ebook ini tidak tersedia untuk diklaim.');
            }

            $existing = UserEbook::where('user_id', $user->id)
                ->where('ebook_id', $ebook->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                throw new \RuntimeException('Kamu sudah memiliki ebook ini.');
            }

            return UserEbook::create([
                'user_id'          => $user->id,
                'ebook_id'         => $ebook->id,
                'acquisition_type' => 'claimed',
                'membership_id'    => $membership->id,
                'price_paid'       => 0,
                'acquired_at'      => now(),
            ]);
        });
    }
}
