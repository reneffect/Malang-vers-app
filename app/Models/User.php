<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property int $xp
 * @property int $level
 * @property int $daily_credit
 * @property Carbon|null $credit_reset_date
 * @property-read int $xp_for_next_level
 */
#[Fillable([
    'name', 'email', 'google_id', 'password', 'phone', 'role',
    'xp', 'level', 'kota', 'tanggal_lahir', 'bio', 'avatar', 'alias_osob',
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
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'xp' => 'integer',
            'level' => 'integer',
            'daily_credit' => 'integer',
            'credit_reset_date' => 'date',
        ];
    }

    // ============================================================
    //  HELPER: Role checks
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

    /** Membership yang sedang aktif (belum expired). */
    public function activeMembership(): HasOne
    {
        return $this->hasOne(Membership::class)
            ->where('status', 'active')
            ->where(function (Builder $query): void {
                $query->where('ends_at', '>', now())
                    ->orWhere(function (Builder $query): void {
                        $query->whereNull('ends_at')
                            ->whereHas('tier', fn (Builder $tierQuery): Builder => $tierQuery->where('slug', 'gratis'));
                    });
            });
    }

    /** Semua riwayat membership. */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /** Semua ebook yang dimiliki (beli satuan / klaim). */
    public function ownedEbooks(): HasMany
    {
        return $this->hasMany(UserEbook::class);
    }

    // ============================================================
    //  MEMBERSHIP HELPERS
    // ============================================================

    /**
     * Ambil MembershipTier aktif user saat ini.
     * Kalau tidak ada / sudah expired → return null (artinya Paket Gratis).
     */
    public function getActivePlan(): ?MembershipTier
    {
        $membership = $this->activeMembership()->with('tier')->first();

        return $membership?->tier;
    }

    /**
     * Ambil paket aktif user, atau paket Gratis dari database jika tidak berlangganan.
     */
    public function getCurrentPlan(): ?MembershipTier
    {
        return $this->getActivePlan()
            ?? MembershipTier::query()->where('slug', 'gratis')->first();
    }

    /**
     * Apakah user saat ini berlangganan Paket Premium aktif?
     */
    public function isPremium(): bool
    {
        $plan = $this->getCurrentPlan();

        return $plan !== null && $plan->slug === 'premium';
    }

    /**
     * Apakah user saat ini berlangganan Paket Standar aktif?
     */
    public function isStandar(): bool
    {
        $plan = $this->getCurrentPlan();

        return $plan !== null && $plan->slug === 'standar';
    }

    /**
     * Apakah user mempunyai membership aktif (Standar atau Premium)?
     */
    public function hasActiveSubscription(): bool
    {
        return in_array($this->getCurrentPlan()?->slug, ['standar', 'premium'], true);
    }

    /**
     * Cek apakah user boleh membaca penuh ebook tertentu.
     *
     * Kriteria boleh baca penuh:
     *   1. Paket Premium aktif → akses semua buku.
     *   2. Sudah beli lisensi satuan ebook tersebut (acquired_type=purchased).
     *   3. Punya klaim ebook tersebut dari Paket Standar (acquired_type=claimed).
     */
    public function canAccessEbook(int $ebookId): bool
    {
        if ($this->isPremium()) {
            return true;
        }

        return $this->ownedEbooks()
            ->where('ebook_id', $ebookId)
            ->exists();
    }

    /**
     * Hitung sisa kredit harian user (dengan lazy reset WIB).
     * Paket Premium → return -1 (unlimited).
     */
    public function getRemainingCredits(): int
    {
        if ($this->getCurrentPlan()?->isUnlimitedTranslate()) {
            return -1; // -1 = unlimited
        }

        $todayWib = Carbon::now('Asia/Jakarta')->toDateString();
        $plan = $this->getCurrentPlan();
        $maxCredits = $plan?->effectiveDailyCredits() ?? 100;

        if ($this->credit_reset_date?->toDateString() !== $todayWib) {
            $this->daily_credit = $maxCredits;
            $this->credit_reset_date = $todayWib;
            $this->save();
        } elseif ((int) $this->daily_credit > $maxCredits) {
            $this->daily_credit = $maxCredits;
            $this->save();
        }

        return max(0, (int) $this->daily_credit);
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
        if ($xpForNext <= 0) {
            return 0.0;
        }

        $safeLevel = max(1, (int) $this->level);
        $currentLevelBaseXp = ($safeLevel - 1) * 50;
        $currentProgress = (int) $this->xp - $currentLevelBaseXp;

        return min(100.0, max(0.0, ($currentProgress / $xpForNext) * 100));
    }

    // ============================================================
    //  ACCESSOR: Label role untuk UI
    // ============================================================

    /** Label role yang siap tampil di UI. */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'superadmin' => 'Super Administrator',
            'admin' => 'Administrator',
            default => 'Member',
        };
    }
}
