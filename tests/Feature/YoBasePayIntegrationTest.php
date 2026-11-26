<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\User;
use App\Services\YoBasePayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class YoBasePayIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private MembershipTier $standarTier;

    private MembershipTier $premiumTier;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.yobasepay.base_url' => 'https://yobasepay.net/api_pay',
            'services.yobasepay.api_key' => 'test_api_key_123',
            'services.yobasepay.webhook_secret' => 'test_secret_xyz',
            'services.yobasepay.channel' => 'SQ',
        ]);

        $this->user = User::factory()->create([
            'name' => 'Arek Malang',
            'email' => 'arek@ngalam.id',
            'role' => 'member',
        ]);

        $this->standarTier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'duration_days' => 30,
            'price' => 19000,
            'monthly_price' => 19000,
            'yearly_price' => 114000,
            'is_active' => true,
            'daily_credits' => 500,
            'claimable_ebooks' => 1,
            'is_unlimited_translate' => false,
        ]);

        $this->premiumTier = MembershipTier::create([
            'name' => 'Paket Premium',
            'slug' => 'premium',
            'duration_days' => 30,
            'price' => 49000,
            'monthly_price' => 49000,
            'yearly_price' => 294000,
            'is_active' => true,
            'is_unlimited_translate' => true,
        ]);
    }

    /**
     * Test 1: Service YoBasePay memvalidasi formula signature HMAC-SHA256 dengan benar.
     */
    public function test_webhook_signature_validation(): void
    {
        $service = app(YoBasePayService::class);

        $payload = [
            'trxid' => 'YOV4-TEST1234',
            'amount' => 49000,
            'status' => 'SUCCESS',
            'timestamp' => '2026-11-26 12:00:00',
        ];

        // Rumus YoBasePay: {trxid}|{amount}|{status}|{timestamp}
        $stringToSign = "{$payload['trxid']}|{$payload['amount']}|{$payload['status']}|{$payload['timestamp']}";
        $validSignature = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        // Valid signature -> true
        $payload['signature'] = $validSignature;
        $this->assertTrue($service->validateWebhookSignature($payload));

        // Invalid signature -> false
        $payload['signature'] = 'invalid_signature_dummy';
        $this->assertFalse($service->validateWebhookSignature($payload));
    }

    /**
     * Test 2: Pembuatan QRIS pembayaran membership memanggil endpoint YoBasePay V4 dengan channel SQ.
     */
    public function test_create_membership_qris_payment_calls_yobasepay_sq_channel(): void
    {
        $freeTier = MembershipTier::create([
            'name' => 'Paket Gratis',
            'slug' => 'gratis',
            'duration_days' => 0,
            'price' => 0,
            'monthly_price' => 0,
            'yearly_price' => 0,
            'is_active' => true,
        ]);
        Membership::create([
            'user_id' => $this->user->id,
            'membership_tier_id' => $freeTier->getKey(),
            'started_at' => now(),
            'status' => 'active',
        ]);

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'trx_id' => 'YOV4-ORDER-999',
                    'method' => 'SQ',
                    'category' => 'qris',
                    'amount_request' => 49000,
                    'amount_to_pay' => 49000,
                    'fee' => 350,
                    'amount_received' => 48650,
                    'qr_image' => 'https://yobasepay.net/qris/qr_test.png',
                    'qr_string' => '00020101021226580016ID.GO.BI.QRIS...',
                    'expired_at' => now()->addMinutes(15)->toDateTimeString(),
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'monthly',
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'is_free' => false,
                'qr_image' => 'https://yobasepay.net/qris/qr_test.png',
            ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'total_amount' => 49000,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('payments', [
            'payment_provider' => 'yobasepay',
            'payment_method' => 'qris',
            'provider_reference' => 'YOV4-ORDER-999',
            'qr_code_url' => 'https://yobasepay.net/qris/qr_test.png',
            'status' => 'pending',
        ]);

        $this->assertFalse($this->user->fresh()->isPremium());
        $this->assertSame('gratis', $this->user->fresh()->getCurrentPlan()?->slug);
    }

    public function test_smartpay_creation_omits_channel_and_persists_gateway_checkout_details(): void
    {
        config(['services.yobasepay.channel' => 'smartpay']);

        $expiresAt = now()->addHour()->format('Y-m-d H:i:s');
        Http::preventStrayRequests();
        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'trx_id' => 'YOV4-SMARTPAY-001',
                    'method' => null,
                    'category' => 'smartpay',
                    'amount_request' => 49000,
                    'checkout_url' => 'https://yobasepay.net/smartpay?slug=checkout001',
                    'payment_url' => 'https://yobasepay.net/smartpay?slug=checkout001',
                    'expired_at' => $expiresAt,
                ],
            ]),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'monthly',
        ]);
        $response->assertOk()
            ->assertJsonPath('checkout_url', 'https://yobasepay.net/smartpay?slug=checkout001')
            ->assertJsonPath('category', 'smartpay');

        $transaction = Transaction::query()
            ->where('user_id', $this->user->id)
            ->firstOrFail();
        $transactionCode = $transaction->transaction_code;

        Http::assertSent(function (Request $request) use ($transactionCode): bool {
            $data = $request->data();
            $expectedSignature = hash_hmac(
                'sha256',
                "test_api_key_123|create_payment|49000|{$transactionCode}",
                'test_secret_xyz'
            );

            return $request->method() === 'POST'
                && parse_url($request->url(), PHP_URL_QUERY) === 'action=create_payment'
                && ! array_key_exists('method', $data)
                && $data['amount'] === 49000
                && $data['ref_id'] === $transactionCode
                && $data['signature'] === $expectedSignature
                && $request->hasHeader('X-API-KEY', 'test_api_key_123')
                && $request->hasHeader('X-Signature', $expectedSignature);
        });

        $this->assertDatabaseHas('payments', [
            'transaction_id' => $transaction->id,
            'payment_method' => 'smartpay',
            'provider_reference' => 'YOV4-SMARTPAY-001',
            'payment_url' => 'https://yobasepay.net/smartpay?slug=checkout001',
            'amount' => 49000,
        ]);
        $this->assertSame($expiresAt, $transaction->fresh()->expires_at->format('Y-m-d H:i:s'));
    }

    public function test_membership_is_activated_only_after_a_valid_yearly_payment(): void
    {
        $this->premiumTier->update(['yearly_price' => 0]);

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'trx_id' => 'YOV4-ANNUAL-001',
                    'amount_request' => 588000,
                    'amount_to_pay' => 588000,
                    'qr_image' => 'https://yobasepay.net/qris/qr_annual.png',
                    'expired_at' => now()->addMinutes(15)->toDateTimeString(),
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'yearly',
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'is_free' => false,
                'amount' => 588000,
            ]);

        $transaction = Transaction::query()->where('user_id', $this->user->id)->firstOrFail();
        $item = $transaction->items()->firstOrFail();

        $this->assertSame('pending', $transaction->status);
        $this->assertSame('yearly', $item->billing_cycle);
        $this->assertFalse($this->user->fresh()->isPremium());

        $timestamp = now()->toDateTimeString();
        $stringToSign = "YOV4-ANNUAL-001|588000|SUCCESS|{$timestamp}";
        $signature = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $this->postJson(route('payment.yobasepay.webhook'), [
            'trxid' => 'YOV4-ANNUAL-001',
            'ref_id' => $transaction->transaction_code,
            'amount' => 588000,
            'status' => 'SUCCESS',
            'timestamp' => $timestamp,
            'signature' => $signature,
        ])->assertOk()
            ->assertJson(['status' => true]);

        $membership = Membership::query()
            ->where('user_id', $this->user->id)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame('yearly', $membership->billing_cycle);
        $this->assertTrue($membership->ends_at->greaterThan(now()->addDays(359)));
        $this->assertTrue($this->user->fresh()->isPremium());
    }

    public function test_smartpay_webhook_accepts_customer_paid_gateway_fee_and_activates_membership(): void
    {
        $transaction = $this->createPendingMembershipTransaction(
            'MV-SMARTPAY-FEE',
            'YOV4-SMARTPAY-FEE',
            49000,
        );
        $transaction->payment()->update(['payment_method' => 'smartpay']);

        $timestamp = now()->toDateTimeString();
        $signature = hash_hmac(
            'sha256',
            "YOV4-SMARTPAY-FEE|50000|SUCCESS|{$timestamp}",
            'test_secret_xyz'
        );

        $response = $this->postJson(route('payment.yobasepay.webhook'), [
            'trxid' => 'YOV4-SMARTPAY-FEE',
            'ref_id' => 'MV-SMARTPAY-FEE',
            'amount' => 50000,
            'amount_request' => 49000,
            'fee' => 1000,
            'net_amount' => 48000,
            'status' => 'SUCCESS',
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);

        $response->assertOk()
            ->assertJson(['status' => true]);
        $this->assertSame('paid', $transaction->fresh()->status);
        $this->assertTrue($this->user->fresh()->isPremium());
    }

    public function test_qris_creation_rejects_gateway_amount_mismatch_without_creating_a_transaction(): void
    {
        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'trx_id' => 'YOV4-WRONG-AMOUNT',
                    'amount_request' => 49001,
                    'amount_to_pay' => 49001,
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'monthly',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Nominal permintaan gateway tidak cocok dengan transaksi.',
            ]);

        $this->assertDatabaseMissing('transactions', ['user_id' => $this->user->id]);
        $this->assertFalse($this->user->fresh()->isPremium());
    }

    public function test_zero_price_paid_tier_is_not_activated_without_payment(): void
    {
        $this->premiumTier->update(['monthly_price' => 0]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'monthly',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Harga paket berbayar tidak valid; paket belum dapat diaktifkan.',
            ]);

        $this->assertDatabaseMissing('transactions', ['user_id' => $this->user->id]);
        $this->assertDatabaseMissing('memberships', ['user_id' => $this->user->id]);
        $this->assertFalse($this->user->fresh()->isPremium());
    }

    /**
     * Test 3: Webhook YoBasePay sukses memverifikasi pembayaran dan mengaktifkan Membership secara otomatis.
     */
    public function test_webhook_successfully_activates_membership_when_signature_is_valid(): void
    {
        // 1. Buat transaksi pending
        $tx = Transaction::create([
            'user_id' => $this->user->id,
            'transaction_code' => 'MV-20261126-PREM01',
            'total_amount' => 49000,
            'status' => 'pending',
        ]);

        $tx->items()->create([
            'item_type' => 'membership_tier',
            'membership_tier_id' => $this->premiumTier->getKey(),
            'item_name_snapshot' => $this->premiumTier->name,
            'quantity' => 1,
            'unit_price' => 49000,
            'subtotal' => 49000,
        ]);

        $tx->payment()->create([
            'payment_provider' => 'yobasepay',
            'payment_method' => 'qris',
            'provider_reference' => 'YOV4-WEBHOOK-123',
            'amount' => 49000,
            'status' => 'pending',
        ]);

        // Pastikan awalnya user belum premium
        $this->assertFalse($this->user->isPremium());

        // 2. Susun payload webhook valid
        $timestamp = now()->toDateTimeString();
        $stringToSign = "YOV4-WEBHOOK-123|49000|SUCCESS|{$timestamp}";
        $signature = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $payload = [
            'event' => 'payment.success',
            'trxid' => 'YOV4-WEBHOOK-123',
            'amount' => 49000,
            'amount_request' => 49000,
            'fee' => 350,
            'net_amount' => 48650,
            'status' => 'SUCCESS',
            'paid_at' => $timestamp,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ];

        // 3. Kirim Webhook
        $response = $this->postJson(route('payment.yobasepay.webhook'), $payload, [
            'X-YoBasePay-Signature-V2' => $signature,
        ]);

        $response->assertOk()
            ->assertJson(['status' => true]);

        // 4. Verifikasi DB terupdate
        $this->assertEquals('paid', $tx->fresh()->status);
        $this->assertEquals('success', $tx->payment->fresh()->status);
        $this->assertTrue($this->user->fresh()->isPremium());
    }

    public function test_webhook_rejects_mismatched_amount_without_activating_membership(): void
    {
        $transaction = $this->createPendingMembershipTransaction(
            'MV-WEBHOOK-AMOUNT-MISMATCH',
            'YOV4-WEBHOOK-AMOUNT-MISMATCH',
            49000,
        );
        $timestamp = now()->toDateTimeString();
        $amount = 48999.5;
        $signature = hash_hmac(
            'sha256',
            "YOV4-WEBHOOK-AMOUNT-MISMATCH|{$amount}|SUCCESS|{$timestamp}",
            'test_secret_xyz'
        );

        $response = $this->postJson(route('payment.yobasepay.webhook'), [
            'trxid' => 'YOV4-WEBHOOK-AMOUNT-MISMATCH',
            'ref_id' => $transaction->transaction_code,
            'amount' => $amount,
            'status' => 'SUCCESS',
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Nominal tagihan gateway tidak cocok dengan transaksi dan biaya yang dilaporkan.',
            ]);

        $this->assertSame('pending', $transaction->fresh()->status);
        $this->assertFalse($this->user->fresh()->isPremium());
    }

    public function test_status_polling_does_not_activate_membership_when_local_payment_amount_differs(): void
    {
        $transaction = $this->createPendingMembershipTransaction(
            'MV-POLL-AMOUNT-MISMATCH',
            'YOV4-POLL-AMOUNT-MISMATCH',
            48000,
        );

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'status' => 'SUCCESS',
                    'trx_id' => 'YOV4-POLL-AMOUNT-MISMATCH',
                    'amount' => 49000,
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(route('payment.status', $transaction->transaction_code));

        $response->assertOk()
            ->assertJson([
                'status' => 'pending',
                'is_paid' => false,
                'verification_error' => 'Nominal pada data pembayaran tidak cocok dengan transaksi.',
            ]);

        $this->assertSame('pending', $transaction->fresh()->status);
        $this->assertFalse($this->user->fresh()->isPremium());
    }

    /**
     * Test 4: Webhook dengan signature palsu / tidak valid ditolak dengan status 403 Forbidden.
     */
    public function test_webhook_rejects_invalid_signature_with_403(): void
    {
        $payload = [
            'event' => 'payment.success',
            'trxid' => 'YOV4-FAKE',
            'amount' => 49000,
            'status' => 'SUCCESS',
            'timestamp' => now()->toDateTimeString(),
            'signature' => 'forged_fake_signature',
        ];

        $response = $this->postJson(route('payment.yobasepay.webhook'), $payload);

        $response->assertStatus(403)
            ->assertJson(['status' => false, 'message' => 'Invalid Signature']);
    }

    /**
     * Test 5: Idempotensi Webhook — Webhook ganda tidak memproses transaksi yang sudah paid dua kali.
     */
    public function test_webhook_idempotency_prevents_duplicate_processing(): void
    {
        $tx = Transaction::create([
            'user_id' => $this->user->id,
            'transaction_code' => 'MV-IDEMPOTENT-01',
            'total_amount' => 49000,
            'status' => 'paid', // Sudah dibayar
            'paid_at' => now(),
        ]);

        $timestamp = now()->toDateTimeString();
        $stringToSign = "YOV4-ALREADY-PAID|49000|SUCCESS|{$timestamp}";
        $signature = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $payload = [
            'trxid' => 'YOV4-ALREADY-PAID',
            'ref_id' => $tx->transaction_code,
            'amount' => 49000,
            'status' => 'SUCCESS',
            'timestamp' => $timestamp,
            'signature' => $signature,
        ];

        $response = $this->postJson(route('payment.yobasepay.webhook'), $payload);

        $response->assertOk()
            ->assertJson(['status' => true]);
    }

    /**
     * Test 6: Pembelian E-Book via QRIS YoBasePay berhasil dan membuka akses penuh setelah dibayar.
     */
    public function test_ebook_purchase_via_qris_and_fulfillment(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('ebooks/dialek1949.pdf', 'test-pdf-content');

        $ebook = Ebook::create([
            'judul' => 'Kamus Dialek Malangan 1949',
            'kode_url' => 'kamus-dialek-1949',
            'penulis' => 'Arema Legend',
            'kategori' => 'Digital',
            'harga' => 50000,
            'harga_lisensi' => 50000,
            'lokasi_berkas' => 'ebooks/dialek1949.pdf',
            'sudah_diterbitkan' => true,
        ]);

        // User awalnya belum punya akses
        $this->assertFalse($this->user->canAccessEbook($ebook->id));

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'trx_id' => 'YOV4-EBOOK-111',
                    'method' => 'SQ',
                    'amount_to_pay' => 50000,
                    'qr_image' => 'https://yobasepay.net/qris/qr_ebook.png',
                    'expired_at' => now()->addMinutes(15)->toDateTimeString(),
                ],
            ], 200),
        ]);

        // Request purchase
        $response = $this->actingAs($this->user)->postJson(route('ebook.purchase', $ebook->id));
        $response->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonPath('amount', 50000);

        $tx = Transaction::where('user_id', $this->user->id)->latest()->first();
        $this->assertNotNull($tx);
        $this->assertSame(50000.0, (float) $tx->total_amount);

        // Simulasi Webhook bayar sukses untuk E-Book
        $timestamp = now()->toDateTimeString();
        $stringToSign = "YOV4-EBOOK-111|50000|SUCCESS|{$timestamp}";
        $signature = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $webhookPayload = [
            'trxid' => 'YOV4-EBOOK-111',
            'ref_id' => $tx->transaction_code,
            'amount' => 50000,
            'status' => 'SUCCESS',
            'timestamp' => $timestamp,
            'signature' => $signature,
        ];

        $this->postJson(route('payment.yobasepay.webhook'), $webhookPayload)->assertOk();

        // User sekarang memiliki akses ke E-Book
        $this->assertTrue($this->user->fresh()->canAccessEbook($ebook->id));
    }

    /**
     * Test 7: Polling status endpoint mengembalikan status transaksi yang valid.
     */
    public function test_payment_status_polling_endpoint(): void
    {
        $tx = Transaction::create([
            'user_id' => $this->user->id,
            'transaction_code' => 'MV-POLL-001',
            'total_amount' => 19000,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(10),
        ]);

        $tx->payment()->create([
            'payment_provider' => 'yobasepay',
            'payment_method' => 'qris',
            'provider_reference' => 'YOV4-POLL-001',
            'amount' => 19000,
            'status' => 'pending',
        ]);

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data' => [
                    'status' => 'PENDING',
                    'trx_id' => 'YOV4-POLL-001',
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->getJson(route('payment.status', $tx->transaction_code));

        $response->assertOk()
            ->assertJson([
                'transaction_code' => 'MV-POLL-001',
                'status' => 'pending',
                'is_paid' => false,
            ]);
    }

    /**
     * Test 8: Pembatalan transaksi pending berhasil.
     */
    public function test_cancel_pending_transaction(): void
    {
        $tx = Transaction::create([
            'user_id' => $this->user->id,
            'transaction_code' => 'MV-CANCEL-001',
            'total_amount' => 19000,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(10),
        ]);

        $tx->payment()->create([
            'payment_provider' => 'yobasepay',
            'payment_method' => 'qris',
            'provider_reference' => 'YOV4-CANCEL-001',
            'amount' => 19000,
            'status' => 'pending',
        ]);

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'message' => 'Payment cancelled',
                'data' => ['status' => 'CANCELLED'],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('payment.cancel', $tx->transaction_code));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals('cancelled', $tx->fresh()->status);
    }

    private function createPendingMembershipTransaction(
        string $transactionCode,
        string $providerReference,
        float $paymentAmount,
        float $transactionAmount = 49000,
        string $billingCycle = 'monthly',
    ): Transaction {
        $transaction = Transaction::create([
            'user_id' => $this->user->id,
            'transaction_code' => $transactionCode,
            'total_amount' => $transactionAmount,
            'status' => 'pending',
            'expires_at' => now()->addMinutes(10),
        ]);

        $transaction->items()->create([
            'item_type' => 'membership_tier',
            'membership_tier_id' => $this->premiumTier->getKey(),
            'billing_cycle' => $billingCycle,
            'item_name_snapshot' => $this->premiumTier->name,
            'quantity' => 1,
            'unit_price' => $transactionAmount,
            'subtotal' => $transactionAmount,
        ]);

        $transaction->payment()->create([
            'payment_provider' => 'yobasepay',
            'payment_method' => 'qris',
            'provider_reference' => $providerReference,
            'amount' => $paymentAmount,
            'status' => 'pending',
        ]);

        return $transaction;
    }
}
