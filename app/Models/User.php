<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name', 'email', 'google_id', 'password', 'phone', 'role',
    'xp', 'level', 'kota', 'tanggal_lahir', 'bio', 'avatar',
    'daily_credit', 'credit_reset_date',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'tanggal_lahir'     => 'date',
            'xp'                => 'integer',
            'level'             => 'integer',
            'daily_credit'      => 'integer',
            'credit_reset_date' => 'date',
        ];
    }

    // ============================================================
    //  HELPER: Cek apakah user adalah admin
    // ============================================================
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    // ============================================================
    //  RELASI
    // ============================================================
    public function activeMembership()
    {
        return $this->hasOne(Membership::class)->where('status', 'active');
    }

    // ============================================================
    //  ACCESSORS: XP & Level Progress
    // ============================================================
    public function getXpForNextLevelAttribute(): int
    {
        $safeLevel = max(1, (int) $this->level);
        return $safeLevel * 50;
    }

    public function getLevelProgressAttribute(): float
    {
        $xpForNext = $this->xp_for_next_level;
        if ($xpForNext <= 0) return 0.0;

        $safeLevel = max(1, (int) $this->level);
        $currentLevelBaseXp = ($safeLevel - 1) * 50;
        $currentProgress = (int) $this->xp - $currentLevelBaseXp;

        return min(100.0, max(0.0, ($currentProgress / $xpForNext) * 100));
    }

    // ============================================================
    //  ACCESSOR: Label role untuk UI
    // ============================================================

    /**
     * Label role yang siap tampil di UI.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin' => 'Super Administrator',
            'admin'      => 'Administrator',
            default      => 'Member',
        };
    }
}