<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom konfigurasi paket (kredit harian, unlimited, dsb.)
 * ke tabel membership_tiers yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            if (! Schema::hasColumn('membership_tiers', 'daily_credits')) {
                // Jumlah kredit harian yang didapat member paket ini (NULL = unlimited)
                $table->unsignedInteger('daily_credits')->nullable()->after('translation_quota')
                    ->comment('NULL = unlimited; 0 = tidak dapat kredit (paket gratis pakai kolom users.daily_credit)');
            }
            if (! Schema::hasColumn('membership_tiers', 'credits_per_word')) {
                // Biaya kredit per kata saat translate
                $table->unsignedTinyInteger('credits_per_word')->default(5)->after('daily_credits');
            }
            if (! Schema::hasColumn('membership_tiers', 'is_unlimited_translate')) {
                // Paket Premium: translate tanpa potong kredit sama sekali
                $table->boolean('is_unlimited_translate')->default(false)->after('credits_per_word');
            }
            if (! Schema::hasColumn('membership_tiers', 'ebook_access_level')) {
                // none = tidak ada, preview = 5 halaman, single = 1 klaim, all = semua buku
                $table->enum('ebook_access_level', ['none', 'preview', 'single', 'all'])
                    ->default('preview')->after('ebook_access');
            }
            if (! Schema::hasColumn('membership_tiers', 'claimable_ebooks')) {
                // Jumlah ebook yang bisa diklaim (Standar = 1)
                $table->unsignedTinyInteger('claimable_ebooks')->default(0)->after('ebook_access_level');
            }
            if (! Schema::hasColumn('membership_tiers', 'preview_pages')) {
                // Jumlah halaman preview untuk non-pemilik
                $table->unsignedTinyInteger('preview_pages')->default(5)->after('claimable_ebooks');
            }
            if (! Schema::hasColumn('membership_tiers', 'show_ads')) {
                // Apakah paket ini masih ditampilkan iklan
                $table->boolean('show_ads')->default(true)->after('preview_pages');
            }
            if (! Schema::hasColumn('membership_tiers', 'show_pro_badge')) {
                // Tampilkan badge PRO di navbar/profil
                $table->boolean('show_pro_badge')->default(false)->after('show_ads');
            }
        });
    }

    public function down(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            $columns = [
                'daily_credits', 'credits_per_word', 'is_unlimited_translate',
                'ebook_access_level', 'claimable_ebooks', 'preview_pages',
                'show_ads', 'show_pro_badge',
            ];

            $existing = array_filter(
                $columns,
                fn (string $col): bool => Schema::hasColumn('membership_tiers', $col)
            );

            if ($existing !== []) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
