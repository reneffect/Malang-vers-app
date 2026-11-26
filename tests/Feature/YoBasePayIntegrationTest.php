<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\User;
use App\Services\YoBasePayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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
            'services.yobasepay.base_url'       => 'https://yobasepay.net/api_pay',
            'services.yobasepay.api_key'        => 'test_api_key_123',
            'services.yobasepay.webhook_secret' => 'test_secret_xyz',
            'services.yobasepay.channel'        => 'SQ',
        ]);

        $this->user = User::factory()->create([
            'name'  => 'Arek Malang',
            'email' => 'arek@ngalam.id',
            'role'  => 'member',
        ]);

        $this->standarTier = MembershipTier::create([
            'name'                   => 'Paket Standar',
            'slug'                   => 'standar',
            'duration_days'          => 30,
            'price'                  => 19000,
            'monthly_price'          => 19000,
            'yearly_price'           => 114000,
            'is_active'              => true,
            'daily_credits'          => 500,
            'claimable_ebooks'       => 1,
            'is_unlimited_translate' => false,
        ]);

        $this->premiumTier = MembershipTier::create([
            'name'                   => 'Paket Premium',
            'slug'                   => 'premium',
            'duration_days'          => 30,
            'price'                  => 49000,
            'monthly_price'          => 49000,
            'yearly_price'           => 294000,
            'is_active'              => true,
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
            'trxid'     => 'YOV4-TEST1234',
            'amount'    => 49000,
            'status'    => 'SUCCESS',
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
        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data'   => [
                    'trx_id'         => 'YOV4-ORDER-999',
                    'ref_id'         => 'MV-TEST-001',
                    'method'         => 'SQ',
                    'category'       => 'qris',
                    'amount_request' => 49000,
                    'amount_to_pay'  => 49000,
                    'fee'            => 350,
                    'amount_received'=> 48650,
                    'qr_image'       => 'https://yobasepay.net/qris/qr_test.png',
                    'qr_string'      => '00020101021226580016ID.GO.BI.QRIS...',
                    'expired_at'     => now()->addMinutes(15)->toDateTimeString(),
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('subscription.create-qris'), [
            'tier_id' => $this->premiumTier->getKey(),
            'billing' => 'monthly',
        ]);

        $response->assertOk()
            ->assertJson([
                'success'  => true,
                'is_free'  => false,
                'qr_image' => 'https://yobasepay.net/qris/qr_test.png',
            ]);

        $this->assertDatabaseHas('transactions', [
            'user_id'      => $this->user->id,
            'total_amount' => 49000,
            'status'       => 'pending',
        ]);

        $this->assertDatabaseHas('payments', [
            'payment_provider'   => 'yobasepay',
            'payment_method'     => 'qris',
            'provider_reference' => 'YOV4-ORDER-999',
            'qr_code_url'        => 'https://yobasepay.net/qris/qr_test.png',
            'status'             => 'pending',
        ]);
    }

    /**
     * Test 3: Webhook YoBasePay sukses memverifikasi pembayaran dan mengaktifkan Membership secara otomatis.
     */
    public function test_webhook_successfully_activates_membership_when_signature_is_valid(): void
    {
        // 1. Buat transaksi pending
        $tx = Transaction::create([
            'user_id'          => $this->user->id,
            'transaction_code' => 'MV-20261126-PREM01',
            'total_amount'     => 49000,
            'status'           => 'pending',
        ]);

        $tx->items()->create([
            'item_type'          => 'membership_tier',
            'membership_tier_id' => $this->premiumTier->getKey(),
            'item_name_snapshot' => $this->premiumTier->name,
            'quantity'           => 1,
            'unit_price'         => 49000,
            'subtotal'           => 49000,
        ]);

        $tx->payment()->create([
            'payment_provider'   => 'yobasepay',
            'payment_method'     => 'qris',
            'provider_reference' => 'YOV4-WEBHOOK-123',
            'amount'             => 49000,
            'status'             => 'pending',
        ]);

        // Pastikan awalnya user belum premium
        $this->assertFalse($this->user->isPremium());

        // 2. Susun payload webhook valid
        $timestamp    = now()->toDateTimeString();
        $stringToSign = "YOV4-WEBHOOK-123|49000|SUCCESS|{$timestamp}";
        $signature    = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $payload = [
            'event'          => 'payment.success',
            'trxid'          => 'YOV4-WEBHOOK-123',
            'amount'         => 49000,
            'amount_request' => 49000,
            'fee'            => 350,
            'net_amount'     => 48650,
            'status'         => 'SUCCESS',
            'paid_at'        => $timestamp,
            'timestamp'      => $timestamp,
            'signature'      => $signature,
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

    /**
     * Test 4: Webhook dengan signature palsu / tidak valid ditolak dengan status 403 Forbidden.
     */
    public function test_webhook_rejects_invalid_signature_with_403(): void
    {
        $payload = [
            'event'     => 'payment.success',
            'trxid'     => 'YOV4-FAKE',
            'amount'    => 49000,
            'status'    => 'SUCCESS',
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
            'user_id'          => $this->user->id,
            'transaction_code' => 'MV-IDEMPOTENT-01',
            'total_amount'     => 49000,
            'status'           => 'paid', // Sudah dibayar
            'paid_at'          => now(),
        ]);

        $timestamp    = now()->toDateTimeString();
        $stringToSign = "YOV4-ALREADY-PAID|49000|SUCCESS|{$timestamp}";
        $signature    = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $payload = [
            'trxid'     => 'YOV4-ALREADY-PAID',
            'ref_id'    => $tx->transaction_code,
            'amount'    => 49000,
            'status'    => 'SUCCESS',
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
        $ebook = Ebook::create([
            'judul'             => 'Kamus Dialek Malangan 1949',
            'kode_url'          => 'kamus-dialek-1949',
            'penulis'           => 'Arema Legend',
            'kategori'          => 'Digital',
            'harga'             => 35000,
            'harga_lisensi'     => 35000,
            'lokasi_berkas'     => 'ebooks/dialek1949.pdf',
            'sudah_diterbitkan' => true,
        ]);

        // User awalnya belum punya akses
        $this->assertFalse($this->user->canAccessEbook($ebook->id));

        Http::fake([
            'https://yobasepay.net/api_pay*' => Http::response([
                'status' => 'Success',
                'data'   => [
                    'trx_id'         => 'YOV4-EBOOK-111',
                    'ref_id'         => 'MV-EBOOK-001',
                    'method'         => 'SQ',
                    'amount_to_pay'  => 35000,
                    'qr_image'       => 'https://yobasepay.net/qris/qr_ebook.png',
                    'expired_at'     => now()->addMinutes(15)->toDateTimeString(),
                ],
            ], 200),
        ]);

        // Request purchase
        $response = $this->actingAs($this->user)->postJson(route('ebook.purchase', $ebook->id));
        $response->assertOk()
            ->assertJson(['success' => true]);

        $tx = Transaction::where('user_id', $this->user->id)->latest()->first();
        $this->assertNotNull($tx);

        // Simulasi Webhook bayar sukses untuk E-Book
        $timestamp    = now()->toDateTimeString();
        $stringToSign = "YOV4-EBOOK-111|35000|SUCCESS|{$timestamp}";
        $signature    = hash_hmac('sha256', $stringToSign, 'test_secret_xyz');

        $webhookPayload = [
            'trxid'     => 'YOV4-EBOOK-111',
            'ref_id'    => $tx->transaction_code,
            'amount'    => 35000,
            'status'    => 'SUCCESS',
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
            'user_id'          => $this->user->id,
            'transaction_code' => 'MV-POLL-001',
            'total_amount'     => 19000,
            'status'           => 'pending',
            'expires_at'       => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($this->user)->getJson(route('payment.status', $tx->transaction_code));

        $response->assertOk()
            ->assertJson([
                'transaction_code' => 'MV-POLL-001',
                'status'           => 'pending',
                'is_paid'          => false,
            ]);
    }

    /**
     * Test 8: Pembatalan transaksi pending berhasil.
     */
    public function test_cancel_pending_transaction(): void
    {
        $tx = Transaction::create([
            'user_id'          => $this->user->id,
            'transaction_code' => 'MV-CANCEL-001',
            'total_amount'     => 19000,
            'status'           => 'pending',
            'expires_at'       => now()->addMinutes(10),
        ]);

        $response = $this->actingAs($this->user)->postJson(route('payment.cancel', $tx->transaction_code));

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals('cancelled', $tx->fresh()->status);
    }
}
