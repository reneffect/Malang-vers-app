<?php

namespace App\Http\Controllers;

use App\Models\DictionaryEntry;
use App\Models\GuestUsage;
use App\Models\SavedPhrase;
use App\Models\TranslationHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalikanController extends Controller
{
    private const FREE_DAILY_LIMIT = 10;

    public function index(): View
    {
        $token = $this->guestToken(request());

        $recentTranslations = $this->historyQuery()->limit(10)->get();
        $popularPhrases = DictionaryEntry::popular()->limit(6)->get();
        $remainingQuota = $this->remainingQuota($token);

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

        $token = $this->guestToken($request);
        $direction = $request->input('direction', 'walikan_to_id');
        $text = $request->input('text');

        // 🔒 Blokir keras (kalau admin set is_blocked)
        if (GuestUsage::isBlocked($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Akun sementara kamu diblokir.',
                'code' => 'BLOCKED',
            ], 403);
        }

        // 🔒 Cek kuota harian (guest / user tanpa langganan)
        if (! $this->userHasActiveSubscription()
            && GuestUsage::todayCount($token) >= self::FREE_DAILY_LIMIT) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota gratis harian habis. Upgrade ke Paket Standar/Premium untuk akses tanpa batas!',
                'code' => 'LIMIT_EXCEEDED',
            ], 429);
        }

        $translated = $this->convertWalikan($text, $direction);

        TranslationHistory::create([
            'original_text' => $text,
            'translated_text' => $translated,
            'direction' => $direction,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
        ]);

        if (! $this->userHasActiveSubscription()) {
            GuestUsage::incrementToday($token);
        }

        return response()->json([
            'success' => true,
            'translated' => $translated,
            'original' => $text,
            'remaining' => $this->remainingQuota($token),
        ])->cookie('walikan_guest_token', $token, 60 * 24 * 30, '/', null, false, true);
    }

    public function popularPhrases()
    {
        $phrases = DictionaryEntry::popular()->limit(6)->get()
            ->map(fn ($p) => [
                'indonesian' => $p->indonesian_word,
                'walikan' => $p->walikan_word,
            ]);

        return response()->json($phrases);
    }

    public function savePhrase(Request $request)
    {
        $request->validate([
            'indonesian_word' => 'required|string',
            'walikan_word' => 'required|string',
        ]);

        SavedPhrase::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'indonesian_word' => $request->indonesian_word,
            ],
            [
                'walikan_word' => $request->walikan_word,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Frasa disimpan!']);
    }

    // ============================================================
    //  LOGIKA KONVERSI WALIKAN (MULTIBYTE SAFE & KAMUS LOKAL)
    // ============================================================

    private function convertWalikan(string $text, string $direction = 'id_to_walikan'): string
    {
        $toWalikan = $direction === 'id_to_walikan';

        return collect(preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE))
            ->map(function ($token) use ($toWalikan) {
                if (trim($token) === '') {
                    return $token;
                }

                if (! preg_match('/^([^\p{L}\p{N}]*)(.*?)([^\p{L}\p{N}]*)$/u', $token, $m)) {
                    return $token;
                }

                [, $leading, $core, $trailing] = $m;
                if ($core === '') {
                    return $token;
                }

                $lower = mb_strtolower($core);

                // 1. Cek Kamus Lokal (PAKAI NAMA KOLOM ASLI)
                $entry = $toWalikan
                    ? DictionaryEntry::where('indonesian_word', $lower)->first()
                    : DictionaryEntry::where('walikan_word', $lower)->first();

                // 2. Fallback: Balik huruf (Multibyte safe)
                $out = $entry
                    ? ($toWalikan ? $entry->walikan_word : $entry->indonesian_word)
                    : implode('', array_reverse(mb_str_split($lower)));

                return $leading.$this->capitalizeFirst($out).$trailing;
            })
            ->implode('');
    }

    private function capitalizeFirst(string $word): string
    {
        if ($word === '') {
            return $word;
        }

        return mb_strtoupper(mb_substr($word, 0, 1)).mb_strtolower(mb_substr($word, 1));
    }

    // ============================================================
    //  HELPER
    // ============================================================

    private function guestToken(Request $request): string
    {
        $token = $request->cookie('walikan_guest_token');

        return $token ?: (string) Str::uuid();
    }

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

    private function userHasActiveSubscription(): bool
    {
        // TODO: Nanti disambung ke model Membership
        return false;
    }

    private function remainingQuota(?string $token): ?int
    {
        if ($this->userHasActiveSubscription()) {
            return null;
        }

        return max(0, self::FREE_DAILY_LIMIT - GuestUsage::todayCount($token));
    }
}
