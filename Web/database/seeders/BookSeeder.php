<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Kamus Alit Boso Walikan (Edisi Lengkap)',
                'deskripsi' => 'Kamus saku praktis untuk pemula yang baru belajar bahasa Walikan.',
                'harga' => 50000,
                'kategori' => 'pemula',
                'rating' => 4.8,
                'terjual' => 120,
                'warna_cover' => 'from-blue-600 via-blue-700 to-indigo-900',
                'is_active' => true,
            ],
            [
                'judul' => 'Kamus Boso Walikan Populer',
                'deskripsi' => 'Kumpulan kata-kata populer yang sering digunakan sehari-hari di Malang.',
                'harga' => 35000,
                'kategori' => 'pemula',
                'rating' => 4.9,
                'terjual' => 340,
                'warna_cover' => 'from-sky-500 via-blue-600 to-blue-800',
                'is_active' => true,
            ],
            [
                'judul' => 'Kamus Boso Walikan Gaya Kuno',
                'deskripsi' => 'Koleksi kata-kata klasik dan tradisional yang jarang diketahui orang.',
                'harga' => 75000,
                'kategori' => 'lengkap',
                'rating' => 4.7,
                'terjual' => 85,
                'warna_cover' => 'from-amber-700 via-yellow-800 to-stone-800',
                'is_active' => true,
            ],
            [
                'judul' => 'Percakapan Sehari-hari Boso Walikan',
                'deskripsi' => 'Panduan dialog praktis untuk percakapan sehari-hari.',
                'harga' => 40000,
                'kategori' => 'lengkap',
                'rating' => 4.6,
                'terjual' => 210,
                'warna_cover' => 'from-orange-400 via-rose-400 to-amber-500',
                'is_active' => true,
            ],
            // Bundle
            [
                'judul' => 'Beli Bundling 4 Kamus Sekalian Hemat 35% via QRIS',
                'deskripsi' => 'Dapatkan 4 e-book sekaligus dengan harga spesial. Akses seumur hidup.',
                'harga' => 115000,
                'harga_asli' => 175000,
                'kategori' => 'bundle',
                'rating' => 5.0,
                'terjual' => 50,
                'warna_cover' => 'from-primary-600 via-purple-600 to-indigo-700',
                'is_bundle' => true,
                'is_active' => true,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
