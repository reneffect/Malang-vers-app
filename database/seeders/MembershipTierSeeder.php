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
                'name' => 'Paket Gratis',
                'description' => 'Coba fitur dasar Boso Walikan tanpa biaya.',
                'duration_days' => 0,
                'price' => 0,
                'monthly_price' => 0,
                'yearly_price' => 0,
                'badge' => null,
                'is_recommended' => false,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Paket Standar',
                'description' => 'Cocok untuk pelajar yang ingin belajar lebih serius.',
                'duration_days' => 30,
                'price' => 10000,
                'monthly_price' => 10000,
                'yearly_price' => 60000,
                'badge' => 'POPULER',
                'is_recommended' => false,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Paket Premium',
                'description' => 'Akses penuh semua fitur untuk pengguna serius.',
                'duration_days' => 30,
                'price' => 49000,
                'monthly_price' => 49000,
                'yearly_price' => 294000,
                'badge' => 'TERBAIK',
                'is_recommended' => true,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($tiers as $tier) {
            MembershipTier::updateOrCreate(
                ['name' => $tier['name']],
                $tier,
            );
        }
    }
}
