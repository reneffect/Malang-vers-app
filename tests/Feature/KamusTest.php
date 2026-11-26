<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
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

        $ebook = Ebook::create([
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
            ->assertSee('Beli /')
            ->assertSee('Baca')
            ->assertSee('href="'.route('ebook.reader', $ebook).'"', false)
            ->assertDontSee('Pratinjau')
            ->assertSee('src="'.Storage::disk('public')->url('covers/kamus-publik-uji.jpg').'"', false)
            ->assertSee('Kamus Boso Walikan')
            ->assertDontSee('Kelola Kamus Boso Walikan');
    }

    public function test_guest_can_open_public_kamus_page_when_no_ebooks_in_database(): void
    {
        $response = $this->get('/kamus');

        $response->assertOk()
            ->assertSee('Kamus Akbar Boso Walikan Malang')
            ->assertSee('Harga Lisensi')
            ->assertSee('50.000');
    }

    public function test_standard_member_keeps_the_free_ebook_claim_action(): void
    {
        $ebook = Ebook::create([
            'judul' => 'Kamus Saku Uji',
            'kode_url' => 'kamus-saku-uji',
            'penulis' => 'Kurator Uji',
            'kategori' => 'pemula',
            'lokasi_berkas' => 'ebooks/kamus-saku-uji.pdf',
            'jumlah_halaman' => 180,
            'terjual' => 0,
            'harga' => 35000,
            'harga_lisensi' => 35000,
            'can_be_claimed' => true,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);
        $expensiveEbook = Ebook::create([
            'judul' => 'Kamus Lengkap Uji',
            'kode_url' => 'kamus-lengkap-uji',
            'penulis' => 'Kurator Uji',
            'kategori' => 'lengkap',
            'lokasi_berkas' => 'ebooks/kamus-lengkap-uji.pdf',
            'jumlah_halaman' => 480,
            'terjual' => 0,
            'harga' => 50000,
            'harga_lisensi' => 50000,
            'can_be_claimed' => true,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);
        $standardTier = MembershipTier::create([
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'daily_credits' => 1000,
            'is_active' => true,
            'order' => 1,
        ]);
        $user = User::factory()->create();
        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $standardTier->id_membership_tier,
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/kamus');

        $response->assertOk()
            ->assertSee('Klaim /')
            ->assertSee('onclick="claimEbook('.$ebook->id, false)
            ->assertSee('Beli /')
            ->assertSee('href="'.route('ebook.reader', $expensiveEbook).'"', false)
            ->assertDontSee('onclick="claimEbook('.$expensiveEbook->id, false);
    }
}
