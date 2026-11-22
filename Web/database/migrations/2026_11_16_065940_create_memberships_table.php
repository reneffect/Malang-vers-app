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
        if (Schema::hasTable('memberships')) {
            if (! Schema::hasColumns('memberships', [
                'id',
                'user_id',
                'membership_tier_id',
                'transaction_item_id',
                'started_at',
                'ends_at',
                'status',
                'created_at',
                'updated_at',
            ])) {
                throw new RuntimeException('The existing memberships table does not match the expected schema.');
            }

            if (! Schema::hasForeignKey('memberships', ['user_id'])) {
                Schema::table('memberships', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('users');
                });
            }

            if (! Schema::hasForeignKey('memberships', ['membership_tier_id'])) {
                Schema::table('memberships', function (Blueprint $table) {
                    $table->foreign('membership_tier_id')
                        ->references('id_membership_tier')
                        ->on('membership_tiers');
                });
            }

            if (! Schema::hasForeignKey('memberships', ['transaction_item_id'])) {
                Schema::table('memberships', function (Blueprint $table) {
                    $table->foreign('transaction_item_id')->references('id')->on('transaction_items');
                });
            }

            if (! Schema::hasIndex('memberships', ['transaction_item_id'], 'unique')) {
                Schema::table('memberships', function (Blueprint $table) {
                    $table->unique('transaction_item_id');
                });
            }

            return;
        }

        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('membership_tier_id')
                ->constrained('membership_tiers', 'id_membership_tier');
            $table->foreignId('transaction_item_id')->nullable()->unique()->constrained('transaction_items');
            $table->dateTime('started_at');
            $table->dateTime('ends_at')->nullable();
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
