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
        Schema::table('membership_tiers', function (Blueprint $table) {
            if (! Schema::hasColumn('membership_tiers', 'monthly_price')) {
                $table->decimal('monthly_price', 12, 2)->default(0);
            }
            if (! Schema::hasColumn('membership_tiers', 'yearly_price')) {
                $table->decimal('yearly_price', 12, 2)->default(0);
            }
            if (! Schema::hasColumn('membership_tiers', 'badge')) {
                $table->string('badge', 50)->nullable();
            }
            if (! Schema::hasColumn('membership_tiers', 'is_recommended')) {
                $table->boolean('is_recommended')->default(false);
            }
            if (! Schema::hasColumn('membership_tiers', 'order')) {
                $table->unsignedInteger('order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            $table->dropColumn([
                'monthly_price',
                'yearly_price',
                'badge',
                'is_recommended',
                'order',
            ]);
        });
    }
};
