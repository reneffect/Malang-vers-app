<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $ebooks = [
            [
                'judul' => 'Kamus Alit Boso Walikan (Edisi Lengkap)',
                'kode_url' => 'kamus-alit-boso-walikan',
                'kategori' => 'pemula',
                'harga' => 50000,
                'terjual' => 120,
            ],
            [
                'judul' => 'Kamus Boso Walikan Populer',
                'kode_url' => 'kamus-boso-walikan-populer',
                'kategori' => 'pemula',
                'harga' => 35000,
                'terjual' => 340,
            ],
            [
                'judul' => 'Kamus Boso Walikan Gaya Kuno',
                'kode_url' => 'kamus-boso-walikan-gaya-kuno',
                'kategori' => 'lengkap',
                'harga' => 75000,
                'terjual' => 85,
            ],
            [
                'judul' => 'Percakapan Sehari-hari Boso Walikan',
                'kode_url' => 'percakapan-sehari-hari-boso-walikan',
                'kategori' => 'lengkap',
                'harga' => 40000,
                'terjual' => 210,
            ],
            [
                'judul' => 'Beli Bundling 4 Kamus Sekalian Hemat 35% via QRIS',
                'kode_url' => 'bundle-4-kamus',
                'kategori' => 'bundle',
                'harga' => 115000,
                'terjual' => 50,
                'is_bundle' => true,
            ],
        ];

        foreach ($ebooks as $ebook) {
            $ebook['lokasi_berkas'] = 'ebooks/seed-data/'.$ebook['kode_url'].'.pdf';
            $ebook['sudah_diterbitkan'] = false;

            Ebook::updateOrCreate(
                ['kode_url' => $ebook['kode_url']],
                $ebook,
            );
        }
    }
}
