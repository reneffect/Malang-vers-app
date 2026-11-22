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
        Schema::create('credit_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_account_id')->constrained('credit_accounts');
            $table->foreignId('translation_history_id')->nullable()->constrained('translation_histories');
            $table->enum('type', ['top_up', 'usage', 'refund']); // ⚠️ jenis_transaksi_kredit
            $table->integer('credit_amount')->comment('Positive for top-up/refund; negative for usage');
            $table->smallInteger('balance_after');
            $table->string('note', 255)->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_histories');
    }
};
