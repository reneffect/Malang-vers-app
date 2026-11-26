<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom harga_lisensi (harga beli satuan permanen) ke buku_digital.
 * Kolom harga yang sudah ada dipakai sebagai harga umum/display;
 * harga_lisensi khusus untuk pembelian lisensi baca penuh.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            if (! Schema::hasColumn('buku_digital', 'harga_lisensi')) {
                $table->decimal('harga_lisensi', 12, 2)->default(0)
                    ->after('harga')
                    ->comment('Harga beli lisensi baca penuh satuan (permanen)');
            }

            if (! Schema::hasColumn('buku_digital', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('penulis');
            }

            if (! Schema::hasColumn('buku_digital', 'can_be_claimed')) {
                // Apakah buku ini bisa diklaim via Paket Standar
                $table->boolean('can_be_claimed')->default(true)->after('harga_lisensi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buku_digital', function (Blueprint $table) {
            $cols = ['harga_lisensi', 'deskripsi', 'can_be_claimed'];
            $existing = array_filter($cols, fn ($c) => Schema::hasColumn('buku_digital', $c));
            if ($existing !== []) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
