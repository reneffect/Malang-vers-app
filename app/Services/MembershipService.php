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
        if (! in_array($billingCycle, ['monthly', 'yearly'], true)) {
            throw new \InvalidArgumentException('Siklus membership tidak valid.');
        }

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
                'user_id' => $user->id,
                'membership_tier_id' => $tier->getKey(),
                'started_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => 'active',
                'billing_cycle' => $billingCycle,
                'payment_reference' => $paymentReference,
            ]);
        });
    }

    /**
     * Ensure a member has a database-backed plan without replacing an active paid plan.
     */
    public function ensureDefaultMembership(User $user): Membership
    {
        return DB::transaction(function () use ($user): Membership {
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->getKey());
            $membership = Membership::query()
                ->where('user_id', $lockedUser->getKey())
                ->active()
                ->lockForUpdate()
                ->first();

            if ($membership) {
                return $membership;
            }

            $freeTier = MembershipTier::query()->where('slug', 'gratis')->first()
                ?? MembershipTier::query()->where('price', 0)->first()
                ?? MembershipTier::create([
                    'name' => 'Paket Gratis',
                    'slug' => 'gratis',
                    'tagline' => 'Selalu gratis selamanya',
                    'description' => 'Paket dasar gratis.',
                    'duration_days' => 0,
                    'price' => 0,
                    'monthly_price' => 0,
                    'yearly_price' => 0,
                    'is_active' => true,
                    'daily_credits' => 100,
                    'credits_per_word' => 5,
                    'is_unlimited_translate' => false,
                    'ebook_access_level' => 'preview',
                    'preview_pages' => 5,
                    'order' => 1,
                ]);

            return $this->activateMembership($lockedUser, $freeTier);
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
        if (! in_array($billingCycle, ['monthly', 'yearly'], true)) {
            throw new \InvalidArgumentException('Siklus membership tidak valid.');
        }

        if (! $tier->is_active) {
            throw new \InvalidArgumentException('Paket membership ini tidak tersedia.');
        }

        $monthlyPrice = (float) $tier->monthly_price;
        $yearlyPrice = (float) $tier->yearly_price;

        if ($yearlyPrice <= 0 && $monthlyPrice > 0) {
            $yearlyPrice = $monthlyPrice * 12;
        }

        $price = $billingCycle === 'yearly' ? $yearlyPrice : $monthlyPrice;

        if ($tier->slug === 'gratis') {
            if ($price !== 0.0) {
                throw new \RuntimeException('Harga Paket Gratis tidak valid.');
            }

            $membership = $this->activateMembership($user, $tier, $billingCycle);

            return [
                'is_free' => true,
                'membership' => $membership,
            ];
        }

        if ($price <= 0) {
            throw new \RuntimeException('Harga paket berbayar tidak valid; paket belum dapat diaktifkan.');
        }

        return DB::transaction(function () use ($user, $tier, $billingCycle, $price) {
            // 1. Buat record transaksi utama
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'transaction_code' => Transaction::generateCode(),
                'total_amount' => $price,
                'status' => 'pending',
                'expires_at' => now()->addMinutes(15),
            ]);

            // 2. Buat snapshot item transaksi
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_type' => 'membership_tier',
                'membership_tier_id' => $tier->getKey(),
                'billing_cycle' => $billingCycle,
                'item_name_snapshot' => $tier->name,
                'quantity' => 1,
                'unit_price' => $price,
                'subtotal' => $price,
            ]);

            // 3. Request pembayaran ke YoBasePay V4
            $gatewayData = $this->yoBasePayService->createPayment($transaction, $user);

            return [
                'is_free' => false,
                'transaction' => $transaction->fresh(['payment', 'items']),
                'gateway' => $gatewayData,
            ];
        });
    }
}
