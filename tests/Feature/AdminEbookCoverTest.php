<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEbookCoverTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_ebook_with_a_cover_image(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.ebooks.store'), [
            'judul' => 'Kamus Sampul Uji',
            'penulis' => 'Kurator Uji',
            'kategori' => 'Akbar',
            'deskripsi' => 'Kamus untuk pengujian.',
            'harga' => 50000,
            'file_pdf' => UploadedFile::fake()->create('kamus.pdf', 10, 'application/pdf'),
            'cover_image' => UploadedFile::fake()->create('sampul.jpg', 10, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('admin.ebooks'));

        $ebook = Ebook::query()->where('judul', 'Kamus Sampul Uji')->firstOrFail();
        $this->assertNotNull($ebook->lokasi_sampul);
        Storage::disk('local')->assertExists($ebook->lokasi_berkas);
        Storage::disk('public')->assertMissing($ebook->lokasi_berkas);
        Storage::disk('public')->assertExists($ebook->lokasi_sampul);
    }

    public function test_admin_cannot_upload_a_non_image_as_ebook_cover(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->from(route('admin.ebooks'))->post(route('admin.ebooks.store'), [
            'judul' => 'Kamus Sampul Invalid',
            'penulis' => 'Kurator Uji',
            'kategori' => 'Akbar',
            'deskripsi' => 'Kamus untuk pengujian.',
            'harga' => 50000,
            'file_pdf' => UploadedFile::fake()->create('kamus.pdf', 10, 'application/pdf'),
            'cover_image' => UploadedFile::fake()->create('sampul.txt', 10, 'text/plain'),
        ]);

        $response->assertSessionHasErrors('cover_image');
        $this->assertDatabaseMissing('buku_digital', [
            'judul' => 'Kamus Sampul Invalid',
        ]);
        Storage::disk('public')->assertDirectoryEmpty('ebooks');
        Storage::disk('local')->assertDirectoryEmpty('ebooks');
    }
}
