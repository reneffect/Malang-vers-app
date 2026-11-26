<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestUsage extends Model
{
    protected $fillable = [
        'guest_token',
        'ip_address',
        'device_fingerprint',
        'usage_count',
        'is_blocked',
        'blocked_at',
        'last_used_at',
    ];

    protected $casts = [
        'is_blocked'   => 'boolean',
        'blocked_at'   => 'datetime',
        'last_used_at' => 'datetime',
    ];

    // ────────────────────────────────────────
    //  STATIC HELPERS (untuk backward compat)
    // ────────────────────────────────────────

    /**
     * Cek apakah guest (ip OR fingerprint) di-blokir.
     */
    public static function isBlocked(?string $token): bool
    {
        return $token && static::where('guest_token', $token)->value('is_blocked');
    }

    /**
     * Cek blocked berdasarkan ip OR fingerprint.
     */
    public static function isBlockedByIdentifiers(?string $ip, ?string $fp): bool
    {
        return static::where(function ($q) use ($ip, $fp) {
            if ($ip) $q->orWhere('ip_address', $ip);
            if ($fp) $q->orWhere('device_fingerprint', $fp);
        })->where('is_blocked', true)->exists();
    }

    /**
     * Hitung lifetime usage untuk sebuah token (backward compat).
     */
    public static function todayCount(?string $token): int
    {
        if (! $token) {
            return 0;
        }

        return (int) static::where('guest_token', $token)->value('usage_count') ?? 0;
    }

    /**
     * Tambah 1 pemakaian (backward compat — lebih baik pakai TranslateQuotaService).
     */
    public static function incrementToday(string $token): void
    {
        $usage = static::firstOrNew(['guest_token' => $token]);
        $usage->usage_count += 1;
        $usage->last_used_at = now();
        $usage->save();
    }
}
