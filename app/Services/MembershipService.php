<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * MembershipService
 *
 * Mengelola aktivasi, perpanjangan, expiry membership,
 * dan inisiasi transaksi QRIS YoBasePay V4 untuk paket langganan.
 */
class MembershipService
{
    public function __construct(
        private readonly YoBasePayService $yoBasePayService,
    ) {}

    /**
     * Aktifkan atau perpanjang membership user setelah pembayaran berhasil diverifikasi.
     * Dibungkus DB::transaction.
     *
     * @return Membership membership yang baru aktif
     */
    public function activateMembership(User $user, MembershipTier $tier, string $billingCycle = 'monthly', ?string $paymentReference = null): Membership
    {
        return DB::transaction(function () use ($user, $tier, $billingCycle, $paymentReference) {
            // Expire membership lama jika ada
            Membership::where('user_id', $user->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->update(['status' => 'expired']);

            $startsAt = Carbon::now();
            $daysToAdd = $billingCycle === 'yearly'
                ? ($tier->duration_days * 12)
                : $tier->duration_days;

            // Gratis: tidak ada ends_at (unlimited / permanen)
            $endsAt = $daysToAdd > 0 ? $startsAt->copy()->addDays($daysToAdd) : null;

            return Membership::create([
                'user_id'            => $user->id,
                'membership_tier_id' => $tier->getKey(),
                'started_at'         => $startsAt,
                'ends_at'            => $endsAt,
                'status'             => 'active',
                'billing_cycle'      => $billingCycle,
                'payment_reference'  => $paymentReference,
            ]);
        });
    }

    /**
     * Auto-downgrade: expire semua membership yang ends_at-nya sudah lewat.
     * Dipanggil oleh middleware CheckSubscriptionExpiry.
     */
    public function expireStaleSubscriptions(User $user): void
    {
        Membership::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('ends_at', '<=', now())
            ->whereNotNull('ends_at')
            ->update(['status' => 'expired']);
    }

    /**
     * Buat transaksi pembelian membership + create QRIS payment via YoBasePay V4.
     */
    public function createMembershipTransaction(User $user, MembershipTier $tier, string $billingCycle = 'monthly'): array
    {
        $price = $billingCycle === 'yearly'
            ? (float) $tier->yearly_price
            : (float) $tier->monthly_price;

        if ($price <= 0) {
            $membership = $this->activateMembership($user, $tier, $billingCycle);
            return [
                'is_free'    => true,
                'membership' => $membership,
            ];
        }

        return DB::transaction(function () use ($user, $tier, $price) {
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
                'item_type'          => 'membership_tier',
                'membership_tier_id' => $tier->getKey(),
                'item_name_snapshot' => $tier->name,
                'quantity'           => 1,
                'unit_price'         => $price,
                'subtotal'           => $price,
            ]);

            // 3. Request QRIS ke YoBasePay V4 (Channel SQ)
            $qrisData = $this->yoBasePayService->createQrisPayment($transaction, $user);

            return [
                'is_free'     => false,
                'transaction' => $transaction->fresh(['payment', 'items']),
                'qris'        => $qrisData,
            ];
        });
    }
}
