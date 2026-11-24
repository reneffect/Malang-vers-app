<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestUsage extends Model
{
    protected $fillable = [
        'guest_token',
        'usage_count',
        'is_blocked',
        'blocked_at',
        'last_used_at',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'blocked_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    /** Sisa pemakaian HARI INI untuk sebuah token */
    public static function todayCount(?string $token): int
    {
        if (! $token) {
            return 0;
        }

        $usage = static::where('guest_token', $token)->first();

        // Belum pernah pakai ATAU terakhir pakai bukan hari ini → hitung 0
        if (! $usage || ! $usage->last_used_at || ! $usage->last_used_at->isToday()) {
            return 0;
        }

        return (int) $usage->usage_count;
    }

    /** Tambah 1 pemakaian (dengan reset harian otomatis) */
    public static function incrementToday(string $token): void
    {
        $usage = static::firstOrNew(['guest_token' => $token]);

        // Reset kalau belum ada / bukan hari ini
        if (! $usage->exists || ! $usage->last_used_at?->isToday()) {
            $usage->usage_count = 0;
        }

        $usage->usage_count += 1;
        $usage->last_used_at = now();
        $usage->save();
    }

    /** Cek apakah token ini diblokir permanen (abuse/bot) */
    public static function isBlocked(?string $token): bool
    {
        return $token && static::where('guest_token', $token)->value('is_blocked');
    }
}
