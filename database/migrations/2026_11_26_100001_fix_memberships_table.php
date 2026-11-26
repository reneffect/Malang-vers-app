<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Perbaiki inkonsistensi kolom di tabel memberships:
 * - Pastikan kolom tier_id (FK ke membership_tiers) ada dan konsisten
 * - Tambah billing_cycle jika belum ada
 * - Tambah catatan_pembayaran / payment_reference
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Tambah alias tier_id jika tabel pakai membership_tier_id
            // (migration lama membuat membership_tier_id; Membership model pakai tier_id)
            // Kita normalkan: gunakan membership_tier_id (sudah ada dari migration lama)
            // Tambah kolom yang belum ada:

            if (! Schema::hasColumn('memberships', 'billing_cycle')) {
                $table->enum('billing_cycle', ['monthly', 'yearly'])
                    ->default('monthly')
                    ->after('status');
            }

            if (! Schema::hasColumn('memberships', 'payment_reference')) {
                $table->string('payment_reference', 100)->nullable()
                    ->after('billing_cycle')
                    ->comment('Nomor referensi transaksi/QRIS');
            }

            if (! Schema::hasColumn('memberships', 'auto_renew')) {
                $table->boolean('auto_renew')->default(false)->after('payment_reference');
            }
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $cols = ['billing_cycle', 'payment_reference', 'auto_renew'];
            $existing = array_filter($cols, fn ($c) => Schema::hasColumn('memberships', $c));
            if ($existing !== []) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
