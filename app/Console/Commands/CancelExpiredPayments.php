<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\PaymentProcessorService;
use App\Services\YoBasePayService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelExpiredPayments extends Command
{
    protected $signature = 'payments:cancel-expired';

    protected $description = 'Batalkan dan tandai expired untuk transaksi yang melewati batas waktu';

    public function handle(
        YoBasePayService $yoBasePayService,
        PaymentProcessorService $paymentProcessor
    ): int {
        $expiredTransactions = Transaction::where('status', 'pending')
            ->where('expires_at', '<=', now())
            ->get();

        $this->info("Menemukan {$expiredTransactions->count()} transaksi kedaluwarsa.");

        foreach ($expiredTransactions as $transaction) {
            // Periksa apakah di YoBasePay status sebenarnya sudah success
            try {
                $gwStatus = $yoBasePayService->checkStatus($transaction->transaction_code);
                $remoteStatus = strtoupper($gwStatus['status'] ?? '');

                if ($remoteStatus === 'SUCCESS') {
                    $paymentProcessor->processTransaction($transaction, 'SUCCESS', $gwStatus);
                    $this->info("Transaksi {$transaction->transaction_code} ternyata telah dibayar!");

                    continue;
                }
            } catch (\Exception $e) {
                Log::warning('Expired payment status could not be checked with YoBasePay', [
                    'transaction_code' => $transaction->transaction_code,
                    'exception' => $e,
                ]);
            }

            // Batalkan di gateway jika bisa
            try {
                $yoBasePayService->cancelPayment($transaction->transaction_code);
            } catch (\Exception $e) {
                Log::warning('Expired payment could not be cancelled with YoBasePay', [
                    'transaction_code' => $transaction->transaction_code,
                    'exception' => $e,
                ]);
            }

            // Tandai expired lokal
            $paymentProcessor->processTransaction($transaction, 'EXPIRED');
            $this->warn("Transaksi {$transaction->transaction_code} ditandai sebagai EXPIRED.");
        }

        return self::SUCCESS;
    }
}
