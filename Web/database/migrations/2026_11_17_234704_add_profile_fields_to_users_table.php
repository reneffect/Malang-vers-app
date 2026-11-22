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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('xp')->default(0)->after('email');
            $table->unsignedTinyInteger('level')->default(1)->after('xp');
            $table->string('kota')->nullable()->after('level');
            $table->date('tanggal_lahir')->nullable()->after('kota');
            $table->text('bio')->nullable()->after('tanggal_lahir');
            $table->string('avatar')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['xp', 'level', 'kota', 'tanggal_lahir', 'bio', 'avatar']);
        });
    }
};
