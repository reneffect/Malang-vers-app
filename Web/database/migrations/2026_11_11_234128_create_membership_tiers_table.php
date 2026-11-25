<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('membership_tiers')) {
            Schema::create('membership_tiers', function (Blueprint $table) {
                $table->id('id_membership_tier');
                $table->string('name', 100);
                $table->string('slug', 100)->nullable()->unique();
                $table->string('tagline')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('duration_days')->default(30);
                $table->decimal('price', 12, 2)->default(0);
                $table->json('benefits')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_featured')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->decimal('monthly_price', 12, 2)->default(0);
                $table->decimal('yearly_price', 12, 2)->default(0);
                $table->unsignedInteger('translation_quota')->nullable();
                $table->enum('ebook_access', ['semua', 'saku', 'khusus'])->default('saku');
                $table->json('features')->nullable();
                $table->string('badge', 50)->nullable();
                $table->boolean('is_recommended')->default(false);
                $table->unsignedInteger('order')->default(0);
                $table->timestamps();
            });

            return;
        }

        Schema::table('membership_tiers', function (Blueprint $table) {
            if (! Schema::hasColumn('membership_tiers', 'slug')) {
                $table->string('slug', 100)->nullable()->unique()->after('name');
            }

            if (! Schema::hasColumn('membership_tiers', 'tagline')) {
                $table->string('tagline')->nullable()->after('name');
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

    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};
