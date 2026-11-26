<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kepemilikan ebook per user:
 * - purchased  = beli satuan (permanen)
 * - claimed    = klaim 1 buku dari Paket Standar
 * - premium    = akses otomatis karena paket Premium (tidak disimpan per buku, cukup cek tier)
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_ebooks')) {
            return;
        }

        Schema::create('user_ebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ebook_id')->constrained('buku_digital')->cascadeOnDelete();
            $table->enum('acquisition_type', ['purchased', 'claimed'])
                ->comment('purchased = beli satuan; claimed = klaim via Paket Standar');
            $table->foreignId('membership_id')->nullable()
                ->constrained('memberships')->nullOnDelete()
                ->comment('Diisi jika acquisition_type = claimed, menunjuk membership aktif saat klaim');
            $table->decimal('price_paid', 12, 2)->default(0)
                ->comment('Harga yang dibayar saat beli satuan; 0 jika klaim');
            $table->foreignId('transaction_id')->nullable()
                ->constrained('transactions')->nullOnDelete();
            $table->timestamp('acquired_at');
            $table->timestamps();

            // Satu user tidak bisa punya entri duplikat untuk ebook yang sama
            $table->unique(['user_id', 'ebook_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ebooks');
    }
};
