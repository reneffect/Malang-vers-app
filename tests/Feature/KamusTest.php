<?php

namespace Tests\Feature;

use App\Models\Ebook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KamusTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_public_kamus_page(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('covers/kamus-publik-uji.jpg', 'cover');

        Ebook::create([
            'judul' => 'Kamus Publik Uji',
            'kode_url' => 'kamus-publik-uji',
            'penulis' => 'Kurator Uji',
            'kategori' => 'pemula',
            'lokasi_berkas' => 'ebooks/kamus-publik-uji.pdf',
            'lokasi_sampul' => 'covers/kamus-publik-uji.jpg',
            'jumlah_halaman' => 480,
            'terjual' => 0,
            'harga' => 15000,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);

        $response = $this->get('/kamus');

        $response->assertOk()
            ->assertSee('Kamus Publik Uji')
            ->assertSee('Oleh: <span class="font-medium text-slate-800">Kurator Uji</span>', false)
            ->assertSee('480 Halaman')
            ->assertSee('PDF HD')
            ->assertSee('Harga Lisensi')
            ->assertSee('Beli / Baca')
            ->assertSee('src="'.Storage::disk('public')->url('covers/kamus-publik-uji.jpg').'"', false)
            ->assertSee('Kamus Boso Walikan')
            ->assertDontSee('Kelola Kamus Boso Walikan');
    }
}
