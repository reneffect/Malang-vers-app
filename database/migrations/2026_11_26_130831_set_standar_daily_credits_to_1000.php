<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('membership_tiers')
            ->where('slug', 'standar')
            ->where('daily_credits', 500)
            ->update(['daily_credits' => 1000]);
    }

    public function down(): void
    {
        DB::table('membership_tiers')
            ->where('slug', 'standar')
            ->where('daily_credits', 1000)
            ->update(['daily_credits' => 500]);
    }
};
