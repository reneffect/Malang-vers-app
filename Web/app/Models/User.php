<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name', 'email', 'password', 'phone',
    'xp', 'level', 'kota', 'tanggal_lahir', 'bio', 'avatar',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'xp' => 'integer',
            'level' => 'integer',
        ];
    }

    // ============================================================
    //  RELASI
    // ============================================================

    /**
     * Relasi ke membership yang sedang aktif
     */
    public function activeMembership()
    {
        return $this->hasOne(Membership::class)->where('status', 'active');
    }

    // ============================================================
    //  ACCESSORS (Untuk menghitung XP & Level Progress)
    // ============================================================

    /**
     * Menghitung XP yang dibutuhkan untuk naik ke level berikutnya.
     * Rumus: Level saat ini × 50 (Contoh: Level 1 butuh 50 XP, Level 2 butuh 100 XP)
     */
    public function getXpForNextLevelAttribute(): int
    {
        // 🛡️ PENGAMAN: Pastikan level minimal 1 agar tidak pernah menghasilkan 0
        $safeLevel = max(1, (int) $this->level);

        return $safeLevel * 50;
    }

    /**
     * Menghitung persentase progress level saat ini (0 - 100%).
     */
    public function getLevelProgressAttribute(): float
    {
        $xpForNext = $this->xp_for_next_level;

        // 🛡️ PENGAMAN: Mencegah Division By Zero jika data XP/Level belum terisi
        if ($xpForNext <= 0) {
            return 0.0;
        }

        $safeLevel = max(1, (int) $this->level);
        $currentLevelBaseXp = ($safeLevel - 1) * 50;
        $currentProgress = (int) $this->xp - $currentLevelBaseXp;

        // Pastikan hasil tidak negatif dan tidak lebih dari 100%
        return min(100.0, max(0.0, ($currentProgress / $xpForNext) * 100));
    }
}
