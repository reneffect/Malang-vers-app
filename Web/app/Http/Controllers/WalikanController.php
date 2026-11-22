<?php

namespace App\Http\Controllers;

use App\Models\DictionaryEntry;
use App\Models\GuestUsage;
use App\Models\SavedPhrase;
use App\Models\TranslationHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WalikanController extends Controller
{
    /** Batas pencarian gratis per hari (guest / user tanpa langganan aktif) */
    private const FREE_DAILY_LIMIT = 10;

    public function index(): View
    {
        // Riwayat 10 terjemahan terakhir (per user, atau per IP untuk guest)
        $recentTranslations = $this->historyQuery()->limit(10)->get();

        // Frasa populer dari dictionary_entries
        $popularPhrases = DictionaryEntry::popular()->limit(6)->get();

        // Info sisa kuota (buat tampilin di UI kalau perlu)
        $remainingQuota = $this->remainingQuota();

        return view('walikan.index', compact(
            'recentTranslations',
            'popularPhrases',
            'remainingQuota'
        ));
    }

    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'direction' => 'nullable|in:id_to_walikan,walikan_to_id',
        ]);

        // 🔒 Cek limit harian untuk guest / user gratis
        if (! $this->userHasActiveSubscription() && GuestUsage::todayCount($request->ip()) >= self::FREE_DAILY_LIMIT) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota gratis harian habis. Upgrade ke Paket Standar/Premium untuk akses tanpa batas!',
                'code' => 'LIMIT_EXCEEDED',
            ], 429);
        }

        $text = $request->input('text');
        $direction = $request->input('direction', 'id_to_walikan');

        $translated = $this->convertWalikan($text);

        // 💾 Simpan riwayat
        TranslationHistory::create([
            'original_text' => $text,
            'translated_text' => $translated,
            'direction' => $direction,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
        ]);

        // 📈 Catat pemakaian (kalau guest / user gratis)
        if (! $this->userHasActiveSubscription()) {
            GuestUsage::incrementToday($request->ip());
        }

        return response()->json([
            'success' => true,
            'translated' => $translated,
            'original' => $text,
            'remaining' => $this->remainingQuota(),
        ]);
    }

    /** Frasa populer via AJAX (opsional, buat refresh tanpa reload) */
    public function popularPhrases()
    {
        $phrases = DictionaryEntry::popular()->limit(6)->get()
            ->map(fn ($p) => [
                'id' => $p->indonesian,
                'walikan' => $p->walikan,
            ]);

        return response()->json($phrases);
    }

    /** Simpan frasa ke 'saved_phrases' (buat member) */
    public function savePhrase(Request $request)
    {
        $request->validate([
            'indonesian' => 'required|string',
            'walikan' => 'required|string',
        ]);

        SavedPhrase::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'indonesian' => $request->indonesian,
            ],
            [
                'walikan' => $request->walikan,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Frasa disimpan!']);
    }

    // ============================================================
    //  LOGIKA KONVERSI WALIKAN (SUDAH DI-FIX)
    // ============================================================

    /**
     * Boso Walikan Malang = balik URUTAN HURUF tiap kata,
     * tapi tanda baca (, . ! ?) TETAP di posisi awalnya.
     *
     * Contoh: "Halo, apa kabar?" → "Olah, apu rabak?"
     */
    private function convertWalikan(string $text): string
    {
        return collect(preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE))
            ->map(function ($token) {
                // Spasi / whitespace → biarkan apa adanya
                if (trim($token) === '') {
                    return $token;
                }

                // Pisahkan: tanda baca di depan, kata inti, tanda baca di belakang
                if (preg_match('/^([^\p{L}\p{N}]*)(.*?)([^\p{L}\p{N}]*)$/u', $token, $m)) {
                    $leading = $m[1];   // misal: " ("
                    $core = $m[2];   // misal: "Halo"
                    $trailing = $m[3];   // misal: ","

                    // Balik HURUF kata intinya saja, lalu kapitalisasi huruf pertama
                    $reversed = $this->capitalizeFirst(strrev($core));

                    return $leading.$reversed.$trailing;
                }

                return $token;
            })
            ->implode('');
    }

    /** Kapitalisasi huruf pertama saja (sisa huruf kecil) */
    private function capitalizeFirst(string $word): string
    {
        if ($word === '') {
            return $word;
        }

        return mb_strtoupper(mb_substr($word, 0, 1)).mb_strtolower(mb_substr($word, 1));
    }

    // ============================================================
    //  HELPER QUERY & AUTH
    // ============================================================

    /** Riwayat: per-user kalau login, per-IP kalau guest */
    private function historyQuery()
    {
        $query = TranslationHistory::query();

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('ip_address', request()->ip());
        }

        return $query->latest();
    }

    /** Cek apakah user punya langganan aktif (nanti nyambung ke tabel memberships) */
    private function userHasActiveSubscription(): bool
    {
        // TODO: kaitkan ke model Membership kalau sudah siap
        // return optional(auth()->user()->activeMembership)->expires_at?->isFuture();
        return false; // sementara: semua dianggap guest
    }

    /** Sisa kuota hari ini */
    private function remainingQuota(): ?int
    {
        if ($this->userHasActiveSubscription()) {
            return null; // unlimited
        }

        return max(0, self::FREE_DAILY_LIMIT - GuestUsage::todayCount(request()->ip()));
    }
}
