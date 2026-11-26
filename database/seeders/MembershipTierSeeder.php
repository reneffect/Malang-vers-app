<?php

namespace Database\Seeders;

use App\Models\MembershipTier;
use Illuminate\Database\Seeder;

class MembershipTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'name'                   => 'Paket Gratis',
                'slug'                   => 'gratis',
                'tagline'                => 'Selalu gratis selamanya untuk pembaca baru',
                'description'            => 'Coba fitur dasar kamus dan terjemahan tanpa biaya.',
                'duration_days'          => 0,
                'price'                  => 0,
                'monthly_price'          => 0,
                'yearly_price'           => 0,
                'badge'                  => null,
                'is_recommended'         => false,
                'is_active'              => true,
                'order'                  => 1,
                // Translate limit
                'daily_credits'          => 100,
                'credits_per_word'       => 5,
                'is_unlimited_translate' => false,
                // E-Book access
                'ebook_access_level'     => 'preview',
                'claimable_ebooks'       => 0,
                'preview_pages'          => 5,
                // UX
                'show_ads'               => true,
                'show_pro_badge'         => false,
            ],
            [
                'name'                   => 'Paket Standar',
                'slug'                   => 'standar',
                'tagline'                => 'Sangat cocok untuk belajar bahasa kiwalan sehari-hari.',
                'description'            => 'Cocok untuk pelajar yang ingin belajar lebih serius.',
                'duration_days'          => 30,
                'price'                  => 19000,
                'monthly_price'          => 19000,
                'yearly_price'           => 114000,
                'badge'                  => 'POPULER',
                'is_recommended'         => false,
                'is_active'              => true,
                'order'                  => 2,
                // Translate limit
                'daily_credits'          => 500,
                'credits_per_word'       => 5,
                'is_unlimited_translate' => false,
                // E-Book access
                'ebook_access_level'     => 'single',
                'claimable_ebooks'       => 1,
                'preview_pages'          => 5,
                // UX
                'show_ads'               => false,
                'show_pro_badge'         => false,
            ],
            [
                'name'                   => 'Paket Premium',
                'slug'                   => 'premium',
                'tagline'                => 'Akses mutlak fitur bahasa Malang & dukungan pelestarian budaya.',
                'description'            => 'Akses penuh semua fitur untuk pengguna serius.',
                'duration_days'          => 30,
                'price'                  => 49000,
                'monthly_price'          => 49000,
                'yearly_price'           => 294000,
                'badge'                  => 'TERBAIK',
                'is_recommended'         => true,
                'is_active'              => true,
                'order'                  => 3,
                // Translate limit
                'daily_credits'          => null, // unlimited
                'credits_per_word'       => 0,
                'is_unlimited_translate' => true,
                // E-Book access
                'ebook_access_level'     => 'all',
                'claimable_ebooks'       => 0,
                'preview_pages'          => 0,
                // UX
                'show_ads'               => false,
                'show_pro_badge'         => true,
            ],
        ];

        foreach ($tiers as $tier) {
            MembershipTier::updateOrCreate(
                ['slug' => $tier['slug']],
                $tier,
            );
        }
    }
}
