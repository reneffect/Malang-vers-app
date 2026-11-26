<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\PaymentProcessorService;
use App\Services\YoBasePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * YoBasePayWebhookController
 *
 * Menerima dan memproses callback notifikasi pembayaran (Webhook) dari YoBasePay V4.
 * Dilengkapi proteksi signature HMAC-SHA256, validasi nominal, dan pencegahan duplikasi.
 */
class YoBasePayWebhookController extends Controller
{
    public function __construct(
        private readonly YoBasePayService $yoBasePayService,
        private readonly PaymentProcessorService $paymentProcessor,
    ) {}

    /**
     * Endpoint Webhook POST /payment/yobasepay/webhook
     */
    public function handle(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $payload = json_decode($content, true);

        if (! is_array($payload)) {
            Log::warning('YoBasePay Webhook: Invalid JSON body');

            return response()->json(['status' => false, 'message' => 'Invalid JSON body'], 400);
        }

        Log::info('YoBasePay Webhook received', [
            'event' => $payload['event'] ?? null,
            'trxid' => $payload['trxid'] ?? null,
            'status' => $payload['status'] ?? null,
        ]);

        // 1. Validasi Signature HMAC-SHA256
        $headerSig = $request->header('X-YoBasePay-Signature-V2')
            ?? $request->header('X-Signature')
            ?? null;

        $isValidSignature = $this->yoBasePayService->validateWebhookSignature($payload, $headerSig);

        if (! $isValidSignature) {
            Log::warning('YoBasePay Webhook: Invalid Signature', [
                'trxid' => $payload['trxid'] ?? null,
                'has_header_signature' => filled($headerSig),
            ]);

            return response()->json(['status' => false, 'message' => 'Invalid Signature'], 403);
        }

        // 2. Ambil parameter transaksi
        $trxid = $payload['trxid'] ?? null;
        $status = strtoupper((string) ($payload['status'] ?? ''));
        $refId = $payload['ref_id'] ?? null;

        // Cari transaksi berdasarkan ref_id (kode transaksi MalangVerse) atau trxid (ID dari YoBasePay)
        $transaction = null;
        if ($refId) {
            $transaction = Transaction::where('transaction_code', $refId)->first();
        }

        if (! $transaction && $trxid) {
            $transaction = Transaction::whereHas('payment', function ($q) use ($trxid) {
                $q->where('provider_reference', $trxid);
            })->first();
        }

        if (! $transaction) {
            Log::warning("YoBasePay Webhook: Transaksi tidak ditemukan untuk trxid {$trxid} / ref_id {$refId}");

            return response()->json(['status' => false, 'message' => 'Transaction not found'], 404);
        }

        // 3. Proses Transaksi secara Idempoten
        $extraData = [
            'trxid' => $trxid,
            'ref_id' => $refId,
            'amount' => $payload['amount'] ?? null,
            'amount_request' => $payload['amount_request'] ?? null,
            'amount_to_pay' => $payload['amount_to_pay'] ?? null,
            'fee' => $payload['fee'] ?? null,
            'net_amount' => $payload['net_amount'] ?? null,
            'paid_at' => $payload['paid_at'] ?? now()->toDateTimeString(),
        ];
        $extraData = array_filter($extraData, static fn (mixed $value): bool => $value !== null);
        $result = $this->paymentProcessor->processTransaction($transaction, $status, $extraData);

        if (! $result['success']) {
            return response()->json([
                'status' => false,
                'message' => $result['message'],
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => $result['message'],
        ], 200);
    }
}
