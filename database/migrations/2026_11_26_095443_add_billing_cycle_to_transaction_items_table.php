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
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->string('billing_cycle', 16)->nullable();
        });

        DB::table('transaction_items')
            ->where('item_type', 'membership_tier')
            ->whereNull('billing_cycle')
            ->update(['billing_cycle' => 'monthly']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('billing_cycle');
        });
    }
};
