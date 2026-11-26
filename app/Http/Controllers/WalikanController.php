<?php

namespace App\Http\Controllers;

use App\Models\DictionaryEntry;
use App\Models\TranslationHistory;
use App\Services\TranslateLimitService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalikanController extends Controller
{
    public function __construct(
        private readonly TranslateLimitService $quota,
    ) {}

    public function index(): View
    {
        $recentTranslations = $this->historyQuery()->limit(10)->get();
        $popularPhrases = DictionaryEntry::popular()->limit(6)->get();

        // Sisa kuota guest
        $remainingQuota = $this->quota->guestRemaining(request());

        return view('walikan.index', compact(
            'recentTranslations',
            'popularPhrases',
            'remainingQuota'
        ));
    }

    public function translate(Request $request): JsonResponse
    {
        $request->validate([
            'text'               => 'required|string|max:1000',
            'direction'          => 'nullable|in:id_to_walikan,walikan_to_id',
            'device_fingerprint' => 'nullable|string|max:64',
        ]);

        $direction = $request->input('direction', 'walikan_to_id');
        $text      = $request->input('text');
        $user      = auth()->user();

        // ════════════════════════════════════════════
        //  A. MEMBER (sudah login)
        // ════════════════════════════════════════════
        if ($user) {
            $check = $this->quota->memberCanTranslate($user, $text);

            if (! $check['allowed']) {
                return response()->json([
                    'success' => false,
                    'message' => "Credit harian tidak cukup. Butuh {$check['cost']} credit ({$check['words']} kata × 5 credit), sisa credit Anda: {$check['balance']}.",
                    'code'    => 'INSUFFICIENT_CREDIT',
                    'quota'   => [
                        'type'    => 'member',
                        'balance' => $check['balance'],
                        'cost'    => $check['cost'],
                        'max'     => TranslateLimitService::memberMaxCredits(),
                    ],
                ], 429);
            }

            // Proses terjemahan
            $translated = $this->convertWalikan($text, $direction);

            // Kurangi credit (atomic, locked)
            $result = $this->quota->consumeMemberCredit($user, $text);

            if (! $result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credit habis saat proses. Silakan coba lagi besok.',
                    'code'    => 'INSUFFICIENT_CREDIT',
                ], 429);
            }

            TranslationHistory::create([
                'original_text'   => $text,
                'translated_text' => $translated,
                'direction'       => $direction,
                'user_id'         => $user->id,
                'ip_address'      => $request->ip(),
            ]);

            return response()->json([
                'success'    => true,
                'translated' => $translated,
                'original'   => $text,
                'remaining'  => $result['balance'],
                'quota'      => [
                    'type'    => 'member',
                    'balance' => $result['balance'],
                    'cost'    => $result['cost'],
                    'words'   => $result['words'],
                    'max'     => TranslateLimitService::memberMaxCredits(),
                ],
            ]);
        }

        // ════════════════════════════════════════════
        //  B. GUEST (belum login)
        // ════════════════════════════════════════════
        $check = $this->quota->guestCanTranslate($request);

        if (! $check['allowed']) {
            $code    = $check['reason'];
            $message = $code === 'BLOCKED'
                ? 'Akun sementara kamu diblokir.'
                : 'Token gratis Anda sudah habis (10 token seumur hidup). Silakan daftar untuk akses unlimited!';

            return response()->json([
                'success' => false,
                'message' => $message,
                'code'    => $code,
                'quota'   => [
                    'type'      => 'guest',
                    'remaining' => 0,
                    'max'       => TranslateLimitService::guestMaxTokens(),
                ],
            ], $code === 'BLOCKED' ? 403 : 429);
        }

        // Proses terjemahan
        $translated = $this->convertWalikan($text, $direction);

        // Kurangi token (atomic, locked)
        $remaining = $this->quota->consumeGuestToken($request);

        TranslationHistory::create([
            'original_text'   => $text,
            'translated_text' => $translated,
            'direction'       => $direction,
            'user_id'         => null,
            'ip_address'      => $request->ip(),
        ]);

        return response()->json([
            'success'    => true,
            'translated' => $translated,
            'original'   => $text,
            'remaining'  => $remaining,
            'quota'      => [
                'type'      => 'guest',
                'remaining' => $remaining,
                'max'       => TranslateLimitService::guestMaxTokens(),
            ],
        ]);
    }

    public function quota(Request $request): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            $info = $this->quota->memberCreditInfo($user);

            return response()->json([
                'type'             => 'member',
                'balance'          => $info['balance'],
                'max'              => $info['max'],
                'credits_per_word' => $info['credits_per_word'],
            ]);
        }

        return response()->json([
            'type'      => 'guest',
            'remaining' => $this->quota->guestRemaining($request),
            'max'       => TranslateLimitService::guestMaxTokens(),
        ]);
    }

    public function popularPhrases()
    {
        $phrases = DictionaryEntry::popular()->limit(6)->get()
            ->map(fn ($p) => [
                'indonesian' => $p->indonesian_word,
                'walikan'    => $p->walikan_word,
            ]);

        return response()->json($phrases);
    }

    public function savePhrase(Request $request)
    {
        $request->validate([
            'indonesian_word' => 'required|string',
            'walikan_word'    => 'required|string',
        ]);

        \App\Models\SavedPhrase::updateOrCreate(
            [
                'user_id'        => auth()->id(),
                'indonesian_word' => $request->indonesian_word,
            ],
            [
                'walikan_word' => $request->walikan_word,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Frasa disimpan!']);
    }

    // ════════════════════════════════════════════
    //  LOGIKA KONVERSI WALIKAN
    // ════════════════════════════════════════════

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

                $entry = $toWalikan
                    ? DictionaryEntry::where('indonesian_word', $lower)->first()
                    : DictionaryEntry::where('walikan_word', $lower)->first();

                $out = $entry
                    ? ($toWalikan ? $entry->walikan_word : $entry->indonesian_word)
                    : implode('', array_reverse(mb_str_split($lower)));

                return $leading . $this->capitalizeFirst($out) . $trailing;
            })
            ->implode('');
    }

    private function capitalizeFirst(string $word): string
    {
        if ($word === '') {
            return $word;
        }

        return mb_strtoupper(mb_substr($word, 0, 1)) . mb_strtolower(mb_substr($word, 1));
    }

    // ════════════════════════════════════════════
    //  HELPER
    // ════════════════════════════════════════════

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
}
