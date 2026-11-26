<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Kamus Akbar Boso Walikan Malang',
                'penulis' => 'Tim Budayawan Arema',
                'deskripsi' => 'Edisi Lengkap Alinea Malangan untuk pelestarian bahasa osob kiwalan.',
                'kategori' => 'kamus',
                'harga' => 50000,
                'harga_lisensi' => 50000,
                'terjual' => 1240,
                'jumlah_halaman' => 480,
                'can_be_claimed' => false,
                'sudah_diterbitkan' => true,
                'is_bundle' => false,
            ],
            [
                'judul' => 'Kamus Saku Kiwalan Populer',
                'penulis' => 'Sam Kaji & Nawak',
                'deskripsi' => 'Panduan Gaul Anak Muda Ngalam dan percakapan kiwalan populer.',
                'kategori' => 'kamus_saku',
                'harga' => 35000,
                'harga_lisensi' => 35000,
                'terjual' => 890,
                'jumlah_halaman' => 180,
                'can_be_claimed' => true,
                'sudah_diterbitkan' => true,
                'is_bundle' => false,
            ],
            [
                'judul' => 'Ensiklopedia Oseb Kiwalan Gerilya 1949',
                'penulis' => 'Sejarah Arema 1949',
                'deskripsi' => 'Sandi Rahasia Pejuang Kemerdekaan Kota Malang tempo doeloe.',
                'kategori' => 'sejarah',
                'harga' => 75000,
                'harga_lisensi' => 75000,
                'terjual' => 680,
                'jumlah_halaman' => 620,
                'can_be_claimed' => false,
                'sudah_diterbitkan' => true,
                'is_bundle' => false,
            ],
            [
                'judul' => 'Percakapan Harian Kiwalan Ngalam',
                'penulis' => 'Komunitas Oseb Ngalam',
                'deskripsi' => 'Edisi Interaksi Sosial Warga dan dialog sehari-hari warga Malang.',
                'kategori' => 'percakapan',
                'harga' => 40000,
                'harga_lisensi' => 40000,
                'terjual' => 610,
                'jumlah_halaman' => 210,
                'can_be_claimed' => false,
                'sudah_diterbitkan' => true,
                'is_bundle' => false,
            ],
            [
                'judul' => 'Paket Bundling 4 Kamus Kiwalan Lengkap',
                'penulis' => 'MalangVerse Publishing',
                'deskripsi' => 'Dapatkan 4 e-book sekaligus dengan harga hemat lisensi seumur hidup.',
                'kategori' => 'bundle',
                'harga' => 115000,
                'harga_lisensi' => 115000,
                'terjual' => 350,
                'jumlah_halaman' => 1490,
                'can_be_claimed' => false,
                'sudah_diterbitkan' => true,
                'is_bundle' => true,
            ],
        ];

        foreach ($books as $book) {
            $slug = Str::slug($book['judul']);
            Ebook::updateOrCreate(
                ['kode_url' => $slug],
                array_merge([
                    'lokasi_sampul' => null,
                    'lokasi_pratinjau' => null,
                    'lokasi_berkas' => "ebooks/{$slug}.pdf",
                ], $book, [
                    'kode_url' => $slug,
                ])
            );
        }

        $this->command->info('✅ Data E-Book berhasil di-seed ke tabel buku_digital!');
    }
}
