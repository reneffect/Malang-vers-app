<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_proofs', function (Blueprint $table) {
            $table->bigIncrements('id_paymentproof');
            $table->unsignedBigInteger('id_payment');
            $table->string('file_path', 255);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            $table->foreign('id_payment')->references('id_payments')->on('payments')->cascadeOnDelete();
            $table->foreign('verified_by')->references('id_users')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_proofs');
    }
};