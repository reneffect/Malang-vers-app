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
            if (! Schema::hasColumn('membership_tiers', 'slug')) {
                $table->string('slug', 100)->nullable()->unique()->after('name');
            }

            if (! Schema::hasColumn('membership_tiers', 'tagline')) {
                $table->string('tagline')->nullable()->after('slug');
            }

            if (! Schema::hasColumn('membership_tiers', 'translation_quota')) {
                $table->unsignedInteger('translation_quota')->nullable()->after('yearly_price');
            }

            if (! Schema::hasColumn('membership_tiers', 'ebook_access')) {
                $table->enum('ebook_access', ['semua', 'saku', 'khusus'])
                    ->default('saku')
                    ->after('translation_quota');
            }

            if (! Schema::hasColumn('membership_tiers', 'features')) {
                $table->json('features')->nullable()->after('ebook_access');
            }

            if (! Schema::hasColumn('membership_tiers', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }

            if (! Schema::hasColumn('membership_tiers', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_tiers', function (Blueprint $table) {
            $columns = array_filter([
                'slug',
                'tagline',
                'translation_quota',
                'ebook_access',
                'features',
                'is_featured',
                'sort_order',
            ], fn (string $column): bool => Schema::hasColumn('membership_tiers', $column));

            if ($columns !== []) {
                $table->dropColumn(array_values($columns));
            }
        });
    }
};
