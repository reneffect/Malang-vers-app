<?php

namespace Tests\Feature;

use App\Models\Ebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EbookStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_pdf_files_are_moved_to_private_storage_and_command_is_idempotent(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $ebook = Ebook::create([
            'judul' => 'E-Book Lama',
            'kode_url' => 'ebook-lama',
            'penulis' => 'Kurator',
            'kategori' => 'Akbar',
            'lokasi_berkas' => 'ebooks/ebook-lama.pdf',
            'lokasi_pratinjau' => 'ebooks/ebook-lama-preview.pdf',
            'jumlah_halaman' => 12,
            'terjual' => 0,
            'harga' => 50000,
            'harga_lisensi' => 50000,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);
        Storage::disk('public')->put($ebook->lokasi_berkas, '%PDF-source');
        Storage::disk('public')->put($ebook->lokasi_pratinjau, '%PDF-preview');
        Storage::disk('public')->put('ebooks/orphan.pdf', '%PDF-orphan');

        $this->artisan('app:secure-ebook-storage')->assertSuccessful();

        Storage::disk('local')->assertExists([
            $ebook->lokasi_berkas,
            $ebook->lokasi_pratinjau,
            'ebooks/orphan.pdf',
        ]);
        Storage::disk('public')->assertMissing([
            $ebook->lokasi_berkas,
            $ebook->lokasi_pratinjau,
            'ebooks/orphan.pdf',
        ]);

        $this->artisan('app:secure-ebook-storage')->assertSuccessful();
    }
}
