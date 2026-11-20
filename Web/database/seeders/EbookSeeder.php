<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul'       => 'Kamus Akbar Boso Walikan Malang',
                'penulis'     => 'Tim Budayawan Arema',
                'deskripsi'   => 'Edisi Lengkap Alinea Malangan',
                'harga'       => 50000,
                'terjual'     => 1240,
                'rating'      => 4.9,
                'halaman'     => 480,
                'format'      => 'PDF',
                'warna_cover' => 'from-blue-600 to-indigo-800',
                'is_active'   => true,
            ],
            [
                'judul'       => 'Kamus Saku Kiwalan Populer',
                'penulis'     => 'Sam Kaji & Nawak',
                'deskripsi'   => 'Panduan Gaul Anak Muda Ngalam',
                'harga'       => 35000,
                'terjual'     => 890,
                'rating'      => 4.8,
                'halaman'     => 180,
                'format'      => 'PDF',
                'warna_cover' => 'from-sky-500 to-blue-700',
                'is_active'   => true,
            ],
            [
                'judul'       => 'Ensiklopedia Oseb Kiwalan Gerilya 1949',
                'penulis'     => 'Sejarah Arema 1949',
                'deskripsi'   => 'Sandi Rahasia Pejuang Kemerdekaan',
                'harga'       => 75000,
                'terjual'     => 680,
                'rating'      => 4.7,
                'halaman'     => 620,
                'format'      => 'PDF',
                'warna_cover' => 'from-amber-700 to-stone-800',
                'is_active'   => true,
            ],
            [
                'judul'       => 'Percakapan Harian Kiwalan Ngalam',
                'penulis'     => 'Komunitas Oseb Ngalam',
                'deskripsi'   => 'Edisi Interaksi Sosial Warga',
                'harga'       => 40000,
                'terjual'     => 610,
                'rating'      => 4.6,
                'halaman'     => 210,
                'format'      => 'PDF',
                'warna_cover' => 'from-orange-400 to-rose-500',
                'is_active'   => true,
            ],
            // Tambah 8 data lagi biar total 12 (sesuai screenshot "12 Judul")
            // ... (bisa di-copy paste struktur di atas dengan data berbeda)
        ];

        // Hapus data lama dulu biar bersih (opsional)
        Ebook::truncate(); 

        foreach ($data as $item) {
            Ebook::create($item);
        }
        
        // Tambah 8 data dummy lagi biar total 12
        for ($i = 5; $i <= 12; $i++) {
            Ebook::create([
                'judul'       => "Kamus Kiwalan Edisi ke-{$i}",
                'penulis'     => 'Tim Kurator',
                'harga'       => 30000 + ($i * 5000),
                'terjual'     => 100 + ($i * 10),
                'rating'      => 4.5,
                'halaman'     => 200,
                'format'      => 'PDF',
                'warna_cover' => 'from-gray-500 to-gray-700',
                'is_active'   => true,
            ]);
        }

        $this->command->info('✅ 12 E-Book berhasil di-seed!');
    }
}