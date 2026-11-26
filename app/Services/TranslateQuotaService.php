<?php

namespace App\Services;

use App\Models\GuestUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslateQuotaService
{
    // ─── Guest Config ───────────────────────────────────────────
    private const GUEST_LIFETIME_TOKENS = 10;

    // ─── Member Config ──────────────────────────────────────────
    private const MEMBER_DAILY_CREDITS  = 100;
    private const CREDITS_PER_WORD      = 5;

    // ════════════════════════════════════════════════════════════
    //  GUEST: Cek & Kurangi Token (IP OR Fingerprint, Lifetime)
    // ════════════════════════════════════════════════════════════

    /**
     * Cek apakah guest masih boleh translate.
     * Identifikasi guest pakai OR: IP atau fingerprint, mana yang sudah pernah tercatat.
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
     */
    public function consumeGuestToken(Request $request): int
    {
        $ip = $this->resolveIp($request);
        $fp = $request->input('device_fingerprint', '');

        return DB::transaction(function () use ($ip, $fp) {
            // Coba cari yang sudah ada (dengan lock)
            $usage = GuestUsage::where(function ($q) use ($ip, $fp) {
                if ($ip) $q->orWhere('ip_address', $ip);
                if ($fp) $q->orWhere('device_fingerprint', $fp);
            })->lockForUpdate()->first();

            if (! $usage) {
                $usage = new GuestUsage();
                $usage->guest_token = $fp ?: $ip ?: bin2hex(random_bytes(16));
                $usage->usage_count = 0;
            }

            // Update identifiers (merge both)
            if ($ip && ! $usage->ip_address) {
                $usage->ip_address = $ip;
            }
            if ($fp && ! $usage->device_fingerprint) {
                $usage->device_fingerprint = $fp;
            }

            $usage->usage_count += 1;
            $usage->last_used_at = now();
            $usage->save();

            return max(0, self::GUEST_LIFETIME_TOKENS - (int) $usage->usage_count);
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
        $used  = $usage ? (int) $usage->usage_count : 0;

        return max(0, self::GUEST_LIFETIME_TOKENS - $used);
    }

    // ════════════════════════════════════════════════════════════
    //  MEMBER: Cek & Kurangi Credit (5 per kata, lazy reset)
    // ════════════════════════════════════════════════════════════

    /**
     * Cek apakah member masih punya cukup credit untuk text ini.
     * Lazy reset: kalau hari sudah ganti → reset ke 100.
     */
    public function memberCanTranslate(User $user, string $text): array
    {
        $user = $this->lazyResetCredit($user);

        $wordCount = $this->countWords($text);
        $cost      = $wordCount * self::CREDITS_PER_WORD;
        $balance   = (int) $user->daily_credit;

        if ($balance < $cost) {
            return [
                'allowed'   => false,
                'reason'    => 'INSUFFICIENT_CREDIT',
                'balance'   => $balance,
                'cost'      => $cost,
                'words'     => $wordCount,
            ];
        }

        return [
            'allowed' => true,
            'balance' => $balance,
            'cost'    => $cost,
            'words'   => $wordCount,
        ];
    }

    /**
     * Kurangi credit member (dengan lockForUpdate agar anti race-condition).
     */
    public function consumeMemberCredit(User $user, string $text): array
    {
        $wordCount = $this->countWords($text);
        $cost = $wordCount * self::CREDITS_PER_WORD;

        return DB::transaction(function () use ($user, $cost, $wordCount) {
            /** @var User $locked */
            $locked = User::where('id', $user->id)->lockForUpdate()->first();

            // Lazy reset di dalam transaksi
            $locked = $this->lazyResetCredit($locked);

            $balance = (int) $locked->daily_credit;

            if ($balance < $cost) {
                return [
                    'success'  => false,
                    'balance'  => $balance,
                    'cost'     => $cost,
                    'words'    => $wordCount,
                ];
            }

            $locked->daily_credit = $balance - $cost;
            $locked->save();

            return [
                'success'  => true,
                'balance'  => (int) $locked->daily_credit,
                'cost'     => $cost,
                'words'    => $wordCount,
            ];
        });
    }

    /**
     * Ambil info credit member saat ini (read-only).
     */
    public function memberCreditInfo(User $user): array
    {
        $user = $this->lazyResetCredit($user);

        return [
            'balance'         => (int) $user->daily_credit,
            'max'             => self::MEMBER_DAILY_CREDITS,
            'credits_per_word' => self::CREDITS_PER_WORD,
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
     * Cari GuestUsage berdasarkan ip OR fingerprint (logika OR).
     */
    private function findGuestUsage(string $ip, string $fp): ?GuestUsage
    {
        return GuestUsage::where(function ($q) use ($ip, $fp) {
            if ($ip) $q->orWhere('ip_address', $ip);
            if ($fp) $q->orWhere('device_fingerprint', $fp);
        })->first();
    }

    /**
     * Lazy reset credit member: kalau credit_reset_date bukan hari ini (WIB),
     * reset daily_credit → 100.
     */
    private function lazyResetCredit(User $user): User
    {
        $todayWib = Carbon::now('Asia/Jakarta')->toDateString();

        if ($user->credit_reset_date !== $todayWib) {
            $user->daily_credit = self::MEMBER_DAILY_CREDITS;
            $user->credit_reset_date = $todayWib;
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
        if ($text === '') return 0;

        return count(preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * Getter statis untuk template.
     */
    public static function guestMaxTokens(): int
    {
        return self::GUEST_LIFETIME_TOKENS;
    }

    public static function memberMaxCredits(): int
    {
        return self::MEMBER_DAILY_CREDITS;
    }

    public static function creditsPerWord(): int
    {
        return self::CREDITS_PER_WORD;
    }
}
