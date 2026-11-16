<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions');
            $table->enum('item_type', ['ebook', 'membership_tier']); // ⚠️
            $table->foreignId('ebook_id')->nullable()->constrained('ebooks');
            $table->foreignId('membership_tier_id')->nullable()->constrained('membership_tiers');
            $table->string('item_name_at_purchase', 200);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamp('created_at')->nullable();
            $table->comment('Fill exactly one product FK according to item_type; validated in Laravel.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_item');
    }
};
