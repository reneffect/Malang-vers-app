<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserEbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;
use Tests\TestCase;

class EbookReaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_member_can_read_four_preview_pages_but_gets_forbidden_for_page_five(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('gratis');
        $ebook = $this->createEbookWithPdf();

        $this->actingAs($user)
            ->get(route('ebook.reader.page', [$ebook, 4]))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');

        $response = $this->actingAs($user)
            ->getJson(route('ebook.reader.page', [$ebook, 5]));

        $response->assertForbidden()
            ->assertJsonPath('message', 'Batas Pratinjau 4 Halaman Tercapai')
            ->assertJsonPath('purchase_url', route('ebook.purchase', $ebook));
    }

    public function test_free_member_can_open_the_preview_reader(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('gratis');
        $ebook = $this->createEbookWithPdf();

        $response = $this->actingAs($user)->get(route('ebook.reader', $ebook));

        $response->assertOk()
            ->assertViewIs('member.ebook-reader')
            ->assertSee('Daftar Isi')
            ->assertSee('Ciutkan daftar isi')
            ->assertSee('Batas Pratinjau 4 Halaman Tercapai')
            ->assertSee('4 halaman pratinjau');

        $this->actingAs($user)
            ->get(route('ebook.reader', [$ebook, 'page' => 5]))
            ->assertOk()
            ->assertSee('Batas Pratinjau 4 Halaman Tercapai');
    }

    public function test_reader_explains_missing_pdf_and_prevents_payment_for_unavailable_ebook(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('gratis');
        $ebook = Ebook::create([
            'judul' => 'Kamus Tanpa PDF',
            'kode_url' => 'kamus-tanpa-pdf',
            'penulis' => 'Kurator',
            'kategori' => 'Akbar',
            'lokasi_berkas' => 'ebooks/kamus-tanpa-pdf.pdf',
            'jumlah_halaman' => 100,
            'harga' => 50000,
            'harga_lisensi' => 50000,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);

        $readerResponse = $this->actingAs($user)->get(route('ebook.reader', $ebook));

        $readerResponse->assertOk()
            ->assertSee('Dokumen PDF belum tersedia')
            ->assertSee('Silakan hubungi admin')
            ->assertDontSee('Buka Versi Lengkap Sekarang');

        $lockedPageResponse = $this->actingAs($user)
            ->get(route('ebook.reader.page', [$ebook, 5]));

        $lockedPageResponse->assertForbidden()
            ->assertSee('Dokumen PDF belum tersedia')
            ->assertDontSee('Beli versi lengkap');

        $purchaseResponse = $this->actingAs($user)->postJson(route('ebook.purchase', $ebook));

        $purchaseResponse->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'File PDF E-Book belum tersedia. Pembelian sementara tidak dapat diproses.');
        $this->assertDatabaseCount((new Transaction)->getTable(), 0);
    }

    public function test_free_member_cannot_open_the_full_pdf_before_purchase(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('gratis');
        $ebook = $this->createEbookWithPdf();

        $this->actingAs($user)
            ->get(route('ebook.read', $ebook))
            ->assertRedirect(route('kamus'));
    }

    public function test_standard_member_must_claim_or_purchase_an_ebook_to_read_page_five(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('standar');
        $ebook = $this->createEbookWithPdf();

        $this->actingAs($user)
            ->get(route('ebook.reader.page', [$ebook, 5]))
            ->assertForbidden();
    }

    public function test_standard_member_cannot_claim_an_ebook_priced_above_35000(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('standar');
        $ebook = $this->createEbookWithPdf();
        $ebook->update(['can_be_claimed' => true]);

        $response = $this->actingAs($user)->postJson(route('ebook.claim', $ebook));

        $response->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'E-Book dengan harga di atas Rp35.000 termasuk akses Paket Premium. Paket Standar dapat membeli lisensi satuan.');
        $this->assertDatabaseCount((new UserEbook)->getTable(), 0);
    }

    public function test_standard_member_can_claim_an_ebook_priced_at_35000(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('standar');
        $ebook = $this->createEbookWithPdf();
        $ebook->update([
            'harga' => 35000,
            'harga_lisensi' => 35000,
            'can_be_claimed' => true,
        ]);

        $response = $this->actingAs($user)->postJson(route('ebook.claim', $ebook));

        $response->assertOk()
            ->assertJsonPath('success', true);
        $this->assertDatabaseHas((new UserEbook)->getTable(), [
            'user_id' => $user->id,
            'ebook_id' => $ebook->id,
            'acquisition_type' => 'claimed',
        ]);
    }

    public function test_premium_member_can_read_the_complete_private_pdf(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('premium');
        $ebook = $this->createEbookWithPdf();

        $response = $this->actingAs($user)->get(route('ebook.read', $ebook));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_standard_member_can_read_a_claimed_ebook_in_full(): void
    {
        Storage::fake('local');
        $user = $this->createMemberWithTier('standar');
        $ebook = $this->createEbookWithPdf();
        $membership = $user->activeMembership()->firstOrFail();
        UserEbook::create([
            'user_id' => $user->id,
            'ebook_id' => $ebook->id,
            'acquisition_type' => 'claimed',
            'membership_id' => $membership->id,
            'price_paid' => 0,
            'acquired_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('ebook.read', $ebook));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    private function createMemberWithTier(string $slug): User
    {
        $tier = MembershipTier::create([
            'name' => 'Paket '.ucfirst($slug),
            'slug' => $slug,
            'duration_days' => $slug === 'gratis' ? 0 : 30,
            'price' => $slug === 'gratis' ? 0 : 19000,
            'monthly_price' => $slug === 'gratis' ? 0 : 19000,
            'yearly_price' => $slug === 'gratis' ? 0 : 190000,
            'daily_credits' => $slug === 'premium' ? null : ($slug === 'standar' ? 1000 : 100),
            'credits_per_word' => $slug === 'premium' ? 0 : 5,
            'is_unlimited_translate' => $slug === 'premium',
            'ebook_access_level' => $slug === 'premium' ? 'all' : 'preview',
            'claimable_ebooks' => $slug === 'standar' ? 1 : 0,
            'preview_pages' => $slug === 'premium' ? 0 : 4,
            'is_active' => true,
        ]);
        $user = User::factory()->create();

        Membership::create([
            'user_id' => $user->id,
            'membership_tier_id' => $tier->getKey(),
            'started_at' => now(),
            'ends_at' => $slug === 'gratis' ? null : now()->addMonth(),
            'status' => 'active',
        ]);

        return $user;
    }

    private function createEbookWithPdf(): Ebook
    {
        $ebook = Ebook::create([
            'judul' => 'Kamus Pembaca',
            'kode_url' => 'kamus-pembaca',
            'penulis' => 'Kurator',
            'kategori' => 'Akbar',
            'lokasi_berkas' => 'ebooks/kamus-pembaca.pdf',
            'jumlah_halaman' => 6,
            'terjual' => 0,
            'harga' => 50000,
            'harga_lisensi' => 50000,
            'sudah_diterbitkan' => true,
            'is_bundle' => false,
        ]);

        Storage::disk('local')->put($ebook->lokasi_berkas, $this->createPdf(6));

        return $ebook;
    }

    private function createPdf(int $pageCount): string
    {
        $pdf = new Fpdi;
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        for ($page = 1; $page <= $pageCount; $page++) {
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, 'Page '.$page);
        }

        return $pdf->Output('test.pdf', 'S');
    }
}
