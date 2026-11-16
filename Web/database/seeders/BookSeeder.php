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
                'title' => 'Kamus Alit Boso Walikan (Edisi Lengkap)',
                'description' => 'Kamus saku praktis untuk pemula yang baru belajar bahasa Walikan.',
                'price' => 50000,
                'category' => 'pemula',
                'rating' => 4.8,
                'sold' => 120,
                'cover_color' => 'from-blue-600 via-blue-700 to-indigo-900',
            ],
            [
                'title' => 'Kamus Boso Walikan Populer',
                'description' => 'Kumpulan kata-kata populer yang sering digunakan sehari-hari di Malang.',
                'price' => 35000,
                'category' => 'pemula',
                'rating' => 4.9,
                'sold' => 340,
                'cover_color' => 'from-sky-500 via-blue-600 to-blue-800',
            ],
            [
                'title' => 'Kamus Boso Walikan Gaya Kuno',
                'description' => 'Koleksi kata-kata klasik dan tradisional yang jarang diketahui orang.',
                'price' => 75000,
                'category' => 'lengkap',
                'rating' => 4.7,
                'sold' => 85,
                'cover_color' => 'from-amber-700 via-yellow-800 to-stone-800',
            ],
            [
                'title' => 'Percakapan Sehari-hari Boso Walikan',
                'description' => 'Panduan dialog praktis untuk percakapan sehari-hari.',
                'price' => 40000,
                'category' => 'lengkap',
                'rating' => 4.6,
                'sold' => 210,
                'cover_color' => 'from-orange-400 via-rose-400 to-amber-500',
            ],
            // Bundle
            [
                'title' => 'Beli Bundling 4 Kamus Sekalian Hemat 35% via QRIS',
                'description' => 'Dapatkan 4 e-book sekaligus dengan harga spesial. Akses seumur hidup.',
                'price' => 115000,
                'original_price' => 175000,
                'category' => 'bundle',
                'rating' => 5.0,
                'sold' => 50,
                'cover_color' => 'from-primary-600 via-purple-600 to-indigo-700',
                'is_bundle' => true,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
