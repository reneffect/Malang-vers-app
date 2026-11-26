<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('membership_tiers')
            ->whereIn('slug', ['gratis', 'standar'])
            ->update(['preview_pages' => 4]);
    }

    public function down(): void
    {
        DB::table('membership_tiers')
            ->whereIn('slug', ['gratis', 'standar'])
            ->update(['preview_pages' => 5]);
    }
};
