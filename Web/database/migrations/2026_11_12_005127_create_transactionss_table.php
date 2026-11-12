<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id_transaction');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_ebooks')->nullable();
            $table->unsignedBigInteger('id_membership_tier')->nullable();
            $table->string('transaction_code', 50)->unique();
            $table->enum('transaction_type', ['ebook', 'membership', 'both']);
            $table->decimal('total', 12, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'expired'])->default('pending');
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->cascadeOnDelete();
            $table->foreign('id_ebooks')->references('id_ebooks')->on('ebooks')->nullOnDelete();
            $table->foreign('id_membership_tier')->references('id_membership_tier')->on('membership_tiers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};