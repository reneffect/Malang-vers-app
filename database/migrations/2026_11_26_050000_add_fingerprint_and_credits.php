<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom fingerprint & ip_address di guest_usages
        //    Ubah dari daily-reset menjadi lifetime-10-token
        Schema::table('guest_usages', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('guest_token');
            $table->string('device_fingerprint', 64)->nullable()->after('ip_address');

            $table->index('ip_address');
            $table->index('device_fingerprint');
        });

        // 2. Tambah kolom credit di users untuk member
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('daily_credit')->default(100)->after('role');
            $table->date('credit_reset_date')->nullable()->after('daily_credit');
        });
    }

    public function down(): void
    {
        Schema::table('guest_usages', function (Blueprint $table) {
            $table->dropIndex(['ip_address']);
            $table->dropIndex(['device_fingerprint']);
            $table->dropColumn(['ip_address', 'device_fingerprint']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['daily_credit', 'credit_reset_date']);
        });
    }
};
