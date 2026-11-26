<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * YoBasePayService
 *
 * Integrasi payment gateway YoBasePay V4 khusus kanal QRIS Realtime (SQ).
 * Menangani create payment, check status, cancel payment, dan validasi webhook signature.
 */
class YoBasePayService
{
    private string $baseUrl;
    private ?string $apiKey;
    private ?string $webhookSecret;
    private string $channel;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl       = rtrim(config('services.yobasepay.base_url', 'https://yobasepay.net/api_pay'), '/');
        $this->apiKey        = config('services.yobasepay.api_key');
        $this->webhookSecret = config('services.yobasepay.webhook_secret');
        $this->channel       = config('services.yobasepay.channel', 'SQ');
        $this->timeout       = (int) config('services.yobasepay.timeout', 15);
    }

    /**
     * Cek apakah API Key telah dikonfigurasi di environment.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiKey) && ! empty($this->webhookSecret);
    }

    /**
     * Buat pembayaran QRIS Realtime (channel SQ) melalui YoBasePay API V4.
     * Mengembalikan data respons terstruktur beserta informasi QRIS.
     *
     * @throws \RuntimeException jika request API gagal
     */
    public function createQrisPayment(Transaction $transaction, ?User $user = null): array
    {
        $user = $user ?? $transaction->user;
        $amount = (int) round($transaction->total_amount);

        // Batas minimal transaksi kanal SQ (Server 2) adalah Rp 10.000
        if ($amount < 10000) {
            throw new \InvalidArgumentException('Nominal pembayaran QRIS minimal Rp 10.000.');
        }

        // Jika kredensial belum diisi (misal dalam mode testing/lokal tanpa kunci riil),
        // gunakan mock generator agar developer tetap dapat menguji alur pembayaran
        if (! $this->isConfigured()) {
            Log::warning('YoBasePay API Key belum dikonfigurasi. Menggunakan simulated QRIS payload untuk testing.');
            return $this->generateSimulatedQrisResponse($transaction, $amount, $user);
        }

        // Susun signature pembuatan pembayaran (HMAC-SHA256)
        // Rumus: hash_hmac('sha256', "api_key|create_payment|amount|ref_id", webhook_secret)
        $signPayload = "{$this->apiKey}|create_payment|{$amount}|{$transaction->transaction_code}";
        $signature = hash_hmac('sha256', $signPayload, (string) $this->webhookSecret);

        $params = [
            'action'         => 'create_payment',
            'api_key'        => $this->apiKey,
            'amount'         => $amount,
            'method'         => $this->channel, // 'SQ' (QRIS Realtime)
            'ref_id'         => $transaction->transaction_code,
            'signature'      => $signature,
            'customer_name'  => $user?->name ?? 'Pelanggan MalangVerse',
            'customer_email' => $user?->email ?? 'customer@malangverse.id',
            'customer_phone' => $user?->phone ?? '081234567890',
        ];

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-API-KEY'   => $this->apiKey,
                    'X-Signature' => $signature,
                    'Accept'      => 'application/json',
                ])
                ->post("{$this->baseUrl}?action=create_payment", $params);

            $body = $response->json();

            if (! $response->successful() || ($body['status'] ?? '') !== 'Success') {
                $errorMsg = $body['message'] ?? $body['error'] ?? 'Gagal membuat pembayaran QRIS di gateway YoBasePay.';
                Log::error('YoBasePay create_payment failed', ['response' => $body, 'status' => $response->status()]);
                throw new \RuntimeException($errorMsg);
            }

            $data = $body['data'];

            // Simpan / update record pembayaran lokal
            $this->savePaymentRecord($transaction, $data);

            return $data;
        } catch (\Exception $e) {
            Log::error('YoBasePay API exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw new \RuntimeException('Koneksi ke gateway pembayaran gagal: ' . $e->getMessage());
        }
    }

    /**
     * Cek status transaksi langsung ke YoBasePay API.
     */
    public function checkStatus(string $trxIdOrRefId): array
    {
        if (! $this->isConfigured()) {
            return [
                'status'  => 'Success',
                'simulated' => true,
                'data'    => [
                    'trx_id' => $trxIdOrRefId,
                    'status' => 'PENDING',
                ],
            ];
        }

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-KEY' => $this->apiKey])
                ->get("{$this->baseUrl}?action=check_status", [
                    'api_key' => $this->apiKey,
                    'trxid'   => $trxIdOrRefId,
                ]);

            $body = $response->json();

            if (! $response->successful() || ($body['status'] ?? '') !== 'Success') {
                throw new \RuntimeException($body['message'] ?? 'Gagal mengecek status pembayaran ke YoBasePay.');
            }

            return $body['data'];
        } catch (\Exception $e) {
            Log::error('YoBasePay check_status exception: ' . $e->getMessage());
            throw new \RuntimeException('Pengecekan status gagal: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan transaksi di YoBasePay (khusus status PENDING).
     */
    public function cancelPayment(string $trxIdOrRefId): array
    {
        if (! $this->isConfigured()) {
            return ['status' => 'Success', 'message' => 'Simulated cancellation'];
        }

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders(['X-API-KEY' => $this->apiKey])
                ->post("{$this->baseUrl}?action=cancel_payment", [
                    'api_key' => $this->apiKey,
                    'trxid'   => $trxIdOrRefId,
                ]);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('YoBasePay cancel_payment exception: ' . $e->getMessage());
            return ['status' => 'Failed', 'message' => $e->getMessage()];
        }
    }

    /**
     * Validasi Signature Webhook HMAC-SHA256 sesuai standar YoBasePay V4:
     * String to Sign: {trxid}|{amount}|{status}|{timestamp}
     */
    public function validateWebhookSignature(array $payload, ?string $headerSignature = null): bool
    {
        $incomingSig = $headerSignature ?: ($payload['signature'] ?? '');

        if (empty($incomingSig)) {
            return false;
        }

        $trxid     = (string) ($payload['trxid'] ?? '');
        $amount    = (string) ($payload['amount'] ?? '');
        $status    = (string) ($payload['status'] ?? '');
        $timestamp = (string) ($payload['timestamp'] ?? '');

        $stringToSign = "{$trxid}|{$amount}|{$status}|{$timestamp}";
        $expectedSig  = hash_hmac('sha256', $stringToSign, (string) $this->webhookSecret);

        return hash_equals($expectedSig, $incomingSig);
    }

    /**
     * Simpan informasi pembayaran ke tabel `payments`.
     */
    public function savePaymentRecord(Transaction $transaction, array $data): Payment
    {
        $expiresAt = isset($data['expired_at'])
            ? Carbon::parse($data['expired_at'])
            : now()->addMinutes(15);

        // Update expires_at pada transaction jika belum ada
        if (! $transaction->expires_at) {
            $transaction->update(['expires_at' => $expiresAt]);
        }

        return Payment::updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'payment_provider'   => 'yobasepay',
                'payment_method'     => 'qris',
                'provider_reference' => $data['trx_id'] ?? null,
                'amount'             => (float) ($data['amount_to_pay'] ?? $transaction->total_amount),
                'fee'                => (float) ($data['fee'] ?? 0),
                'net_amount'         => (float) ($data['amount_received'] ?? $transaction->total_amount),
                'status'             => 'pending',
                'settlement_status'  => 'holding',
                'payment_url'        => $data['payment_url'] ?? null,
                'qr_code_url'        => $data['qr_image'] ?? null,
                'qr_string'          => $data['qr_string'] ?? null,
                'expires_at'         => $expiresAt,
                'gateway_response'   => $data,
            ]
        );
    }

    /**
     * Generator mock response untuk simulasi lokal jika kredensial belum diatur.
     */
    private function generateSimulatedQrisResponse(Transaction $transaction, int $amount, ?User $user): array
    {
        $mockTrxId = 'YOV4-SIM-' . strtoupper(substr(md5($transaction->transaction_code), 0, 8));
        $expiredAt = now()->addMinutes(15)->format('Y-m-d H:i:s');

        // Dummy standard QRIS image for local preview
        $dummyQrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226580016ID.GO.BI.QRIS011893600911000000000002081020392052045812530336054' . str_pad($amount, 5, '0', STR_PAD_LEFT) . '5802ID5920MALANGVERSE%20DIGITAL6006MALANG61056511162160712' . $transaction->transaction_code . '6304';

        $data = [
            'trx_id'          => $mockTrxId,
            'ref_id'          => $transaction->transaction_code,
            'method'          => 'SQ',
            'method_name'     => 'QRIS Realtime (Simulasi)',
            'receiver_name'   => 'MALANGVERSE DIGITAL NUSANTARA',
            'category'        => 'qris',
            'amount_request'  => $amount,
            'amount_to_pay'   => $amount,
            'fee'             => 350,
            'amount_received' => $amount - 350,
            'fee_payer'       => 'merchant',
            'payment_url'     => null,
            'qr_image'        => $dummyQrImage,
            'qr_string'       => '00020101021226580016ID.GO.BI.QRIS011893600911000000000002081020392052045812530336054' . $amount . '5802ID5920MALANGVERSE6006MALANG6304ABCD',
            'expired_at'      => $expiredAt,
            'is_simulated'    => true,
        ];

        $this->savePaymentRecord($transaction, $data);

        return $data;
    }
}
