<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * YoBasePayService
 *
 * Integrasi multi-kanal payment gateway YoBasePay V4.
 * Menangani create payment, check status, cancel payment, dan validasi webhook signature.
 */
class YoBasePayService
{
    private string $baseUrl;

    private ?string $apiKey;

    private ?string $webhookSecret;

    private ?string $channel;

    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.yobasepay.base_url', 'https://yobasepay.net/api_pay'), '/');
        $this->apiKey = config('services.yobasepay.api_key');
        $this->webhookSecret = config('services.yobasepay.webhook_secret');
        $configuredChannel = strtoupper(trim((string) config('services.yobasepay.channel', 'smartpay')));
        $this->channel = $configuredChannel === '' || strtolower($configuredChannel) === 'smartpay'
            ? null
            : $configuredChannel;
        $this->timeout = (int) config('services.yobasepay.timeout', 15);
    }

    /**
     * Cek apakah API dan webhook credentials telah dikonfigurasi.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiKey) && ! empty($this->webhookSecret);
    }

    /**
     * Create a SmartPay checkout or a payment using the configured channel.
     *
     * @throws \RuntimeException when the gateway request or response is invalid
     */
    public function createPayment(Transaction $transaction, ?User $user = null): array
    {
        $user = $user ?? $transaction->user;
        $amount = (int) round($transaction->total_amount);

        $minimumAmount = $this->channel === 'SQ' ? 10000 : 5000;

        if ($amount < $minimumAmount) {
            throw new \InvalidArgumentException('Nominal pembayaran minimal Rp '.number_format($minimumAmount, 0, ',', '.').'.');
        }

        if (! $this->isConfigured()) {
            if (! app()->environment(['local', 'testing'])) {
                throw new \RuntimeException('Konfigurasi YoBasePay belum lengkap.');
            }

            Log::warning('YoBasePay belum dikonfigurasi. Menggunakan simulasi pembayaran lokal.');

            return $this->generateSimulatedQrisResponse($transaction, $amount, $user);
        }

        // Susun signature pembuatan pembayaran (HMAC-SHA256)
        // Rumus: hash_hmac('sha256', "api_key|create_payment|amount|ref_id", webhook_secret)
        $signPayload = "{$this->apiKey}|create_payment|{$amount}|{$transaction->transaction_code}";
        $signature = hash_hmac('sha256', $signPayload, (string) $this->webhookSecret);

        $params = [
            'api_key' => $this->apiKey,
            'amount' => $amount,
            'ref_id' => $transaction->transaction_code,
            'signature' => $signature,
            'customer_name' => $user?->name,
            'customer_email' => $user?->email,
            'customer_phone' => $user?->phone,
        ];
        $params = array_filter($params, static fn (mixed $value): bool => $value !== null && $value !== '');

        if ($this->channel !== null) {
            $params['method'] = $this->channel;
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(min(5, $this->timeout))
                ->timeout($this->timeout)
                ->withHeaders([
                    'X-API-KEY' => $this->apiKey,
                    'X-Signature' => $signature,
                ])
                ->post("{$this->baseUrl}?action=create_payment", $params);
        } catch (ConnectionException $e) {
            Log::error('YoBasePay create_payment connection failed', [
                'transaction_code' => $transaction->transaction_code,
                'exception' => $e,
            ]);

            throw new \RuntimeException('Koneksi ke gateway pembayaran gagal.', previous: $e);
        }

        $body = $response->json();

        if (! $response->successful() || ! is_array($body) || ($body['status'] ?? '') !== 'Success') {
            $errorMessage = is_array($body)
                ? ($body['message'] ?? $body['error'] ?? 'Gagal membuat pembayaran di gateway YoBasePay.')
                : 'Respons pembayaran dari gateway tidak valid.';

            Log::error('YoBasePay create_payment failed', [
                'status' => $response->status(),
                'message' => $errorMessage,
                'transaction_code' => $transaction->transaction_code,
            ]);

            throw new \RuntimeException($errorMessage);
        }

        $data = $body['data'] ?? null;

        if (! is_array($data)) {
            throw new \RuntimeException('Respons pembayaran dari gateway tidak valid.');
        }

        $this->savePaymentRecord($transaction, $data);

        return $data;
    }

    /**
     * Cek status transaksi langsung ke YoBasePay API.
     */
    public function checkStatus(string $trxIdOrRefId): array
    {
        if (! $this->isConfigured()) {
            if (! app()->environment(['local', 'testing'])) {
                throw new \RuntimeException('Konfigurasi YoBasePay belum lengkap.');
            }

            return [
                'status' => 'PENDING',
                'simulated' => true,
                'trx_id' => $trxIdOrRefId,
            ];
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(min(5, $this->timeout))
                ->timeout($this->timeout)
                ->withHeaders(['X-API-KEY' => $this->apiKey])
                ->get("{$this->baseUrl}?action=check_status", [
                    'api_key' => $this->apiKey,
                    'trxid' => $trxIdOrRefId,
                ]);

            $body = $response->json();

            if (! $response->successful() || ! is_array($body) || ($body['status'] ?? '') !== 'Success') {
                $message = is_array($body) ? ($body['message'] ?? 'Gagal mengecek status pembayaran ke YoBasePay.') : 'Respons status pembayaran tidak valid.';

                throw new \RuntimeException($message);
            }

            if (! is_array($body['data'] ?? null) || ! is_string($body['data']['status'] ?? null)) {
                throw new \RuntimeException('Respons status pembayaran dari gateway tidak valid.');
            }

            return $body['data'];
        } catch (ConnectionException $e) {
            Log::error('YoBasePay check_status connection failed', ['exception' => $e]);

            throw new \RuntimeException('Pengecekan status gagal karena koneksi gateway.', previous: $e);
        }
    }

    /**
     * Batalkan transaksi di YoBasePay (khusus status PENDING).
     */
    public function cancelPayment(string $trxIdOrRefId): array
    {
        if (! $this->isConfigured()) {
            if (! app()->environment(['local', 'testing'])) {
                throw new \RuntimeException('Konfigurasi YoBasePay belum lengkap.');
            }

            return [
                'status' => 'Success',
                'data' => ['status' => 'CANCELLED'],
                'simulated' => true,
            ];
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(min(5, $this->timeout))
                ->timeout($this->timeout)
                ->withHeaders(['X-API-KEY' => $this->apiKey])
                ->post("{$this->baseUrl}?action=cancel_payment", [
                    'api_key' => $this->apiKey,
                    'trxid' => $trxIdOrRefId,
                ]);
        } catch (ConnectionException $e) {
            Log::error('YoBasePay cancel_payment connection failed', ['exception' => $e]);

            throw new \RuntimeException('Pembatalan pembayaran gagal karena koneksi gateway.', previous: $e);
        }

        $body = $response->json();

        if (
            ! $response->successful()
            || ! is_array($body)
            || ($body['status'] ?? '') !== 'Success'
            || strtoupper((string) ($body['data']['status'] ?? '')) !== 'CANCELLED'
        ) {
            $message = is_array($body)
                ? ($body['message'] ?? 'Gateway belum mengonfirmasi pembatalan pembayaran.')
                : 'Respons pembatalan pembayaran tidak valid.';

            throw new \RuntimeException($message);
        }

        return $body;
    }

    /**
     * Validasi Signature Webhook HMAC-SHA256 sesuai standar YoBasePay V4:
     * String to Sign: {trxid}|{amount}|{status}|{timestamp}
     */
    public function validateWebhookSignature(array $payload, ?string $headerSignature = null): bool
    {
        if (! is_string($this->webhookSecret) || trim($this->webhookSecret) === '') {
            return false;
        }

        $incomingSig = $headerSignature ?: ($payload['signature'] ?? '');

        if (! is_string($incomingSig) || trim($incomingSig) === '') {
            return false;
        }

        foreach (['trxid', 'amount', 'status', 'timestamp'] as $requiredField) {
            if (! isset($payload[$requiredField]) || ! is_scalar($payload[$requiredField])) {
                return false;
            }
        }

        if (! is_numeric($payload['amount'])) {
            return false;
        }

        $trxid = (string) ($payload['trxid'] ?? '');
        $amount = (string) ($payload['amount'] ?? '');
        $status = (string) ($payload['status'] ?? '');
        $timestamp = (string) ($payload['timestamp'] ?? '');

        $stringToSign = "{$trxid}|{$amount}|{$status}|{$timestamp}";
        $expectedSig = hash_hmac('sha256', $stringToSign, (string) $this->webhookSecret);

        return hash_equals($expectedSig, $incomingSig);
    }

    /**
     * Simpan informasi pembayaran ke tabel `payments`.
     */
    public function savePaymentRecord(Transaction $transaction, array $data): Payment
    {
        if ($transaction->status !== 'pending') {
            throw new \RuntimeException('Pembayaran hanya dapat dibuat untuk transaksi pending.');
        }

        $expectedAmount = (float) $transaction->total_amount;
        $requestAmount = $data['amount_request'] ?? $data['amount'] ?? $data['amount_to_pay'] ?? null;

        if (! is_numeric($requestAmount) || abs((float) $requestAmount - $expectedAmount) > 0.01) {
            throw new \RuntimeException('Nominal permintaan gateway tidak cocok dengan transaksi.');
        }

        $fee = $data['fee'] ?? 0;

        if ($fee !== null && (! is_numeric($fee) || (float) $fee < 0)) {
            throw new \RuntimeException('Biaya gateway tidak valid.');
        }

        foreach (['amount_to_pay', 'amount'] as $chargeField) {
            if (! array_key_exists($chargeField, $data)) {
                continue;
            }

            $chargeAmount = $data[$chargeField];
            $isBaseAmount = is_numeric($chargeAmount) && abs((float) $chargeAmount - $expectedAmount) <= 0.01;
            $includesGatewayFee = is_numeric($chargeAmount)
                && is_numeric($fee)
                && abs((float) $chargeAmount - ($expectedAmount + (float) $fee)) <= 0.01;

            if (! $isBaseAmount && ! $includesGatewayFee) {
                throw new \RuntimeException('Total tagihan gateway tidak cocok dengan transaksi dan biaya yang dilaporkan.');
            }
        }

        $providerReference = trim((string) ($data['trx_id'] ?? ''));

        if ($providerReference === '') {
            throw new \RuntimeException('Referensi pembayaran dari gateway tidak tersedia.');
        }

        if (isset($data['ref_id']) && (string) $data['ref_id'] !== $transaction->transaction_code) {
            throw new \RuntimeException('Kode referensi dari gateway tidak cocok dengan transaksi.');
        }

        $existingPayment = Payment::query()
            ->where('transaction_id', $transaction->id)
            ->first();

        if ($existingPayment?->status === 'success') {
            throw new \RuntimeException('Transaksi ini sudah dibayar dan tidak dapat dibuat ulang.');
        }

        $expiresAt = isset($data['expired_at'])
            ? Carbon::parse($data['expired_at'])
            : now()->addMinutes(15);

        if ($expiresAt->isPast()) {
            throw new \RuntimeException('Waktu kedaluwarsa pembayaran dari gateway sudah lewat.');
        }

        $rawCategory = $data['category'] ?? ($this->channel === 'SQ' ? 'qris' : 'smartpay');

        if (! is_string($rawCategory)) {
            throw new \RuntimeException('Kategori metode pembayaran dari gateway tidak valid.');
        }

        $category = strtolower(trim($rawCategory));
        $category = match ($category) {
            'e-money' => 'emoney',
            'virtual account' => 'virtual_account',
            default => $category,
        };
        $allowedCategories = ['qris', 'virtual_account', 'emoney', 'retail', 'pulsa', 'smartpay'];

        if (! in_array($category, $allowedCategories, true)) {
            throw new \RuntimeException('Kategori metode pembayaran dari gateway tidak valid.');
        }

        $checkoutUrl = $data['checkout_url'] ?? null;

        if (! is_string($checkoutUrl) || trim($checkoutUrl) === '') {
            $checkoutUrl = $data['payment_url'] ?? null;
        }

        $paymentUrl = $this->validateGatewayUrl($checkoutUrl, 'URL checkout');
        $qrCodeUrl = $this->validateGatewayUrl($data['qr_image'] ?? null, 'URL QR');

        if ($category === 'smartpay' && $paymentUrl === null && $qrCodeUrl === null && empty($data['qr_string'])) {
            throw new \RuntimeException('Gateway tidak mengembalikan tautan checkout atau data QR pembayaran.');
        }

        $transaction->update(['expires_at' => $expiresAt]);

        return Payment::updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'payment_provider' => 'yobasepay',
                'payment_method' => $category,
                'provider_reference' => $providerReference,
                'amount' => (float) $requestAmount,
                'fee' => (float) ($data['fee'] ?? 0),
                'net_amount' => (float) ($data['amount_received'] ?? $transaction->total_amount),
                'status' => 'pending',
                'settlement_status' => 'holding',
                'payment_url' => $paymentUrl,
                'qr_code_url' => $qrCodeUrl,
                'qr_string' => $data['qr_string'] ?? null,
                'expires_at' => $expiresAt,
                'gateway_response' => $data,
            ]
        );
    }

    /**
     * Generator mock response untuk simulasi lokal jika kredensial belum diatur.
     */
    private function generateSimulatedQrisResponse(Transaction $transaction, int $amount, ?User $user): array
    {
        $mockTrxId = 'YOV4-SIM-'.strtoupper(substr(md5($transaction->transaction_code), 0, 8));
        $expiredAt = now()->addMinutes(15)->format('Y-m-d H:i:s');

        // Dummy standard QRIS image for local preview
        $dummyQrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226580016ID.GO.BI.QRIS011893600911000000000002081020392052045812530336054'.str_pad($amount, 5, '0', STR_PAD_LEFT).'5802ID5920MALANGVERSE%20DIGITAL6006MALANG61056511162160712'.$transaction->transaction_code.'6304';

        $data = [
            'trx_id' => $mockTrxId,
            'ref_id' => $transaction->transaction_code,
            'method' => 'SQ',
            'method_name' => 'QRIS Realtime (Simulasi)',
            'receiver_name' => 'MALANGVERSE DIGITAL NUSANTARA',
            'category' => 'qris',
            'amount_request' => $amount,
            'amount_to_pay' => $amount,
            'fee' => 350,
            'amount_received' => $amount - 350,
            'fee_payer' => 'merchant',
            'payment_url' => null,
            'qr_image' => $dummyQrImage,
            'qr_string' => '00020101021226580016ID.GO.BI.QRIS011893600911000000000002081020392052045812530336054'.$amount.'5802ID5920MALANGVERSE6006MALANG6304ABCD',
            'expired_at' => $expiredAt,
            'is_simulated' => true,
        ];

        $this->savePaymentRecord($transaction, $data);

        return $data;
    }

    private function validateGatewayUrl(mixed $url, string $field): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        if (! is_string($url)) {
            throw new \RuntimeException("{$field} dari gateway tidak valid.");
        }

        $parts = parse_url($url);

        if (($parts['scheme'] ?? null) !== 'https' || empty($parts['host'])) {
            throw new \RuntimeException("{$field} dari gateway harus menggunakan HTTPS.");
        }

        return $url;
    }
}
