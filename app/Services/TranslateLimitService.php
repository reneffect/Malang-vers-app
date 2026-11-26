<?php

namespace App\Services;

use App\Models\GuestUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * TranslateLimitService
 *
 * Mengelola kuota terjemahan untuk:
 *  - Guest   : lifetime 10 token, dilacak via IP + fingerprint (OR logic)
 *  - Gratis  : 100 kredit harian, reset 00:00 WIB, 5 kredit/kata
 *  - Standar : kredit harian sesuai tabel plans (dinamis), 5 kredit/kata
 *  - Premium : UNLIMITED (tidak ada pemotongan kredit sama sekali)
 */
class TranslateLimitService
{
    // ─── Guest Config ───────────────────────────────────────────
    private const GUEST_LIFETIME_TOKENS = 10;

    // ─── Default Member Config (fallback jika plan tidak ada) ──
    private const DEFAULT_DAILY_CREDITS = 100;

    private const DEFAULT_CREDITS_PER_WORD = 5;

    // ════════════════════════════════════════════════════════════
    //  GUEST: Cek & Kurangi Token (IP OR Fingerprint, Lifetime)
    // ════════════════════════════════════════════════════════════

    /**
     * Cek apakah guest masih boleh translate.
     * Identifikasi guest pakai OR: IP atau fingerprint.
     *
     * @return array{allowed: bool, reason?: string, remaining: int}
     */
    public function guestCanTranslate(Request $request): array
    {
        $ip = $this->resolveIp($request);
        $fp = $request->input('device_fingerprint', '');

        $usage = $this->findGuestUsage($ip, $fp);

        if ($usage && $usage->is_blocked) {
            return ['allowed' => false, 'reason' => 'BLOCKED', 'remaining' => 0];
        }

        $used = $usage ? (int) $usage->usage_count : 0;
        $remaining = max(0, self::GUEST_LIFETIME_TOKENS - $used);

        if ($remaining <= 0) {
            return ['allowed' => false, 'reason' => 'LIMIT_EXCEEDED', 'remaining' => 0];
        }

        return ['allowed' => true, 'remaining' => $remaining];
    }

    /**
     * Kurangi 1 token guest (dengan lock agar anti race-condition).
     * Return sisa token setelah dikurangi.
     */
    public function consumeGuestToken(Request $request): array
    {
        $ip = $this->resolveIp($request);
        $fp = $request->input('device_fingerprint', '');

        return DB::transaction(function () use ($ip, $fp): array {
            $usage = GuestUsage::where(function ($q) use ($ip, $fp) {
                if ($ip) {
                    $q->orWhere('ip_address', $ip);
                }
                if ($fp) {
                    $q->orWhere('device_fingerprint', $fp);
                }
            })->lockForUpdate()->first();

            if ($usage?->is_blocked) {
                return ['allowed' => false, 'reason' => 'BLOCKED', 'remaining' => 0];
            }

            if ($usage && (int) $usage->usage_count >= self::GUEST_LIFETIME_TOKENS) {
                return ['allowed' => false, 'reason' => 'LIMIT_EXCEEDED', 'remaining' => 0];
            }

            if (! $usage) {
                $usage = new GuestUsage;
                $usage->guest_token = $fp ?: $ip ?: bin2hex(random_bytes(16));
                $usage->usage_count = 0;
            }

            if ($ip && ! $usage->ip_address) {
                $usage->ip_address = $ip;
            }
            if ($fp && ! $usage->device_fingerprint) {
                $usage->device_fingerprint = $fp;
            }

            $usage->usage_count += 1;
            $usage->last_used_at = now();
            $usage->save();

            return [
                'allowed' => true,
                'remaining' => max(0, self::GUEST_LIFETIME_TOKENS - (int) $usage->usage_count),
            ];
        });
    }

    /**
     * Hitung sisa token guest (read-only, tanpa lock).
     */
    public function guestRemaining(Request $request): int
    {
        $ip = $this->resolveIp($request);
        $fp = $request->input('device_fingerprint', '');
        $usage = $this->findGuestUsage($ip, $fp);
        $used = $usage ? (int) $usage->usage_count : 0;

        return max(0, self::GUEST_LIFETIME_TOKENS - $used);
    }

    // ════════════════════════════════════════════════════════════
    //  MEMBER: Cek & Kurangi Credit (plan-aware, lazy reset WIB)
    // ════════════════════════════════════════════════════════════

    /**
     * Cek apakah member masih punya cukup credit untuk text ini.
     * Lazy reset: kalau hari sudah ganti → reset sesuai plan.
     * Premium → selalu allowed tanpa cek saldo.
     *
     * @return array{allowed: bool, reason?: string, balance: int, max: int, cost: int, credits_per_word: int, words: int, is_unlimited: bool}
     */
    public function memberCanTranslate(User $user, string $text): array
    {
        $plan = $user->getCurrentPlan();

        if ($plan?->isUnlimitedTranslate()) {
            return [
                'allowed' => true,
                'balance' => -1,
                'max' => -1,
                'cost' => 0,
                'credits_per_word' => 0,
                'words' => $this->countWords($text),
                'is_unlimited' => true,
            ];
        }

        $user = $this->lazyResetCredit($user);
        $plan = $user->getCurrentPlan();
        $max = $plan?->effectiveDailyCredits() ?? self::DEFAULT_DAILY_CREDITS;
        $perWord = $plan?->effectiveCreditsPerWord() ?? self::DEFAULT_CREDITS_PER_WORD;
        $wordCount = $this->countWords($text);
        $cost = $wordCount * $perWord;
        $balance = (int) $user->daily_credit;

        if ($balance < $cost) {
            return [
                'allowed' => false,
                'reason' => 'INSUFFICIENT_CREDIT',
                'balance' => $balance,
                'max' => $max,
                'cost' => $cost,
                'credits_per_word' => $perWord,
                'words' => $wordCount,
                'is_unlimited' => false,
            ];
        }

        return [
            'allowed' => true,
            'balance' => $balance,
            'max' => $max,
            'cost' => $cost,
            'credits_per_word' => $perWord,
            'words' => $wordCount,
            'is_unlimited' => false,
        ];
    }

    /**
     * Kurangi credit member (dengan lockForUpdate agar anti race-condition).
     * Premium → tidak ada pemotongan, langsung return sukses.
     *
     * @return array{success: bool, balance: int, max: int, cost: int, credits_per_word: int, words: int, is_unlimited: bool}
     */
    public function consumeMemberCredit(User $user, string $text): array
    {
        $wordCount = $this->countWords($text);

        return DB::transaction(function () use ($user, $wordCount) {
            /** @var User $locked */
            $locked = User::where('id', $user->id)->lockForUpdate()->first();
            $plan = $locked->getCurrentPlan();

            if ($plan?->isUnlimitedTranslate()) {
                return [
                    'success' => true,
                    'balance' => -1,
                    'max' => -1,
                    'cost' => 0,
                    'credits_per_word' => 0,
                    'words' => $wordCount,
                    'is_unlimited' => true,
                ];
            }

            // Lazy reset di dalam transaksi (atomic)
            $locked = $this->lazyResetCredit($locked);

            $plan = $locked->getCurrentPlan();
            $max = $plan?->effectiveDailyCredits() ?? self::DEFAULT_DAILY_CREDITS;
            $perWord = $plan?->effectiveCreditsPerWord() ?? self::DEFAULT_CREDITS_PER_WORD;
            $cost = $wordCount * $perWord;
            $balance = (int) $locked->daily_credit;

            if ($balance < $cost) {
                return [
                    'success' => false,
                    'balance' => $balance,
                    'max' => $max,
                    'cost' => $cost,
                    'credits_per_word' => $perWord,
                    'words' => $wordCount,
                    'is_unlimited' => false,
                ];
            }

            $locked->daily_credit = $balance - $cost;
            $locked->save();

            return [
                'success' => true,
                'balance' => (int) $locked->daily_credit,
                'max' => $max,
                'cost' => $cost,
                'credits_per_word' => $perWord,
                'words' => $wordCount,
                'is_unlimited' => false,
            ];
        });
    }

    /**
     * Ambil saldo dan batas kredit yang sudah diselaraskan dengan paket aktif.
     *
     * @return array{balance: int, max: int, credits_per_word: int, is_unlimited: bool}
     */
    public function memberCreditInfo(User $user): array
    {
        $user->refresh();
        $plan = $user->getCurrentPlan();

        if ($plan?->isUnlimitedTranslate()) {
            return [
                'balance' => -1,
                'max' => -1,
                'credits_per_word' => 0,
                'is_unlimited' => true,
            ];
        }

        $user = $this->lazyResetCredit($user);
        $plan = $user->getCurrentPlan();
        $max = $plan?->effectiveDailyCredits() ?? self::DEFAULT_DAILY_CREDITS;
        $perWord = $plan?->effectiveCreditsPerWord() ?? self::DEFAULT_CREDITS_PER_WORD;

        return [
            'balance' => (int) $user->daily_credit,
            'max' => $max,
            'credits_per_word' => $perWord,
            'is_unlimited' => false,
        ];
    }

    // ════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ════════════════════════════════════════════════════════════

    /**
     * Resolve IP dengan support Cloudflare / proxy headers.
     */
    private function resolveIp(Request $request): string
    {
        return $request->header('CF-Connecting-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip()
            ?? '0.0.0.0';
    }

    /**
     * Cari GuestUsage berdasarkan ip OR fingerprint.
     */
    private function findGuestUsage(string $ip, string $fp): ?GuestUsage
    {
        return GuestUsage::where(function ($q) use ($ip, $fp) {
            if ($ip) {
                $q->orWhere('ip_address', $ip);
            }
            if ($fp) {
                $q->orWhere('device_fingerprint', $fp);
            }
        })->first();
    }

    /**
     * Lazy reset credit member: kalau credit_reset_date bukan hari ini (WIB),
     * reset daily_credit sesuai plan aktif (atau default 100).
     */
    private function lazyResetCredit(User $user): User
    {
        $todayWib = Carbon::now('Asia/Jakarta')->toDateString();

        $plan = $user->getCurrentPlan();
        $maxCredits = $plan?->effectiveDailyCredits() ?? self::DEFAULT_DAILY_CREDITS;

        if ($user->credit_reset_date?->toDateString() !== $todayWib) {
            $user->daily_credit = $maxCredits;
            $user->credit_reset_date = $todayWib;
            $user->save();
        } elseif ((int) $user->daily_credit > $maxCredits) {
            $user->daily_credit = $maxCredits;
            $user->save();
        }

        return $user;
    }

    /**
     * Hitung jumlah kata dalam teks.
     */
    private function countWords(string $text): int
    {
        $text = trim($text);
        if ($text === '') {
            return 0;
        }

        return count(preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY));
    }

    // ════════════════════════════════════════════════════════════
    //  STATIC GETTERS (untuk template / JS)
    // ════════════════════════════════════════════════════════════

    public static function guestMaxTokens(): int
    {
        return self::GUEST_LIFETIME_TOKENS;
    }

    public static function defaultDailyCredits(): int
    {
        return self::DEFAULT_DAILY_CREDITS;
    }

    public static function memberMaxCredits(): int
    {
        return self::DEFAULT_DAILY_CREDITS;
    }

    public static function defaultCreditsPerWord(): int
    {
        return self::DEFAULT_CREDITS_PER_WORD;
    }

    public static function creditsPerWord(): int
    {
        return self::DEFAULT_CREDITS_PER_WORD;
    }
}
