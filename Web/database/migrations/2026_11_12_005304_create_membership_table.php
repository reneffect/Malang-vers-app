<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->bigIncrements('id_membership_user');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_membership_tier');
            $table->unsignedBigInteger('id_transaction')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->cascadeOnDelete();
            $table->foreign('id_membership_tier')->references('id_membership_tier')->on('membership_tiers')->cascadeOnDelete();
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};