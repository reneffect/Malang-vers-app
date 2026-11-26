<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method', 50)->default('qris')->change();
            $table->text('payment_url')->nullable()->change();
            $table->text('qr_code_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('payments')
            ->whereNotIn('payment_method', ['qris', 'bank_transfer', 'manual'])
            ->update(['payment_method' => 'manual']);

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['qris', 'bank_transfer', 'manual'])->default('qris')->change();
        });

        // Keep URL columns widened; shrinking them could truncate gateway links already stored.
    }
};
