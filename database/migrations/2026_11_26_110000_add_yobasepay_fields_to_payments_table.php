<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'qr_string')) {
                $table->text('qr_string')->nullable()->after('qr_code_url')
                    ->comment('Raw QRIS string value from gateway for local QR generation');
            }

            if (! Schema::hasColumn('payments', 'fee')) {
                $table->decimal('fee', 12, 2)->default(0)->after('amount')
                    ->comment('Transaction fee charged by gateway');
            }

            if (! Schema::hasColumn('payments', 'net_amount')) {
                $table->decimal('net_amount', 12, 2)->default(0)->after('fee')
                    ->comment('Net amount received after fee deduction');
            }

            if (! Schema::hasColumn('payments', 'settlement_status')) {
                $table->string('settlement_status', 50)->nullable()->after('status')
                    ->comment('Holding / Released');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $cols = ['qr_string', 'fee', 'net_amount', 'settlement_status'];
            $existing = array_filter($cols, fn ($c) => Schema::hasColumn('payments', $c));
            if (! empty($existing)) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
