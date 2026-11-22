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
        if (DB::table('transaction_items')->exists()) {
            throw new RuntimeException('Cannot complete transaction_items because existing rows need product details before migration.');
        }

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->enum('item_type', ['ebook', 'membership_tier']);
            $table->foreignId('ebook_id')->nullable()->constrained('buku_digital');
            $table->foreignId('membership_tier_id')->nullable();
            $table->string('item_name_snapshot', 200);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->foreign('membership_tier_id')
                ->references('id_membership_tier')
                ->on('membership_tiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['ebook_id']);
            $table->dropForeign(['membership_tier_id']);
            $table->dropColumn([
                'transaction_id',
                'item_type',
                'ebook_id',
                'membership_tier_id',
                'item_name_snapshot',
                'quantity',
                'unit_price',
                'subtotal',
            ]);
        });
    }
};
