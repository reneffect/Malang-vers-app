<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'user_id',
        'membership_tier_id',
        'started_at',
        'ends_at',
        'status',
        'billing_cycle',
        'payment_reference',
        'auto_renew',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    // ============================================================
    //  RELASI
    // ============================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke MembershipTier.
     * FK di memberships: membership_tier_id → PK di membership_tiers: id_membership_tier
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id', 'id_membership_tier');
    }

    /** Ebook yang diklaim dari membership Standar ini. */
    public function claimedEbooks(): HasMany
    {
        return $this->hasMany(UserEbook::class, 'membership_id');
    }

    // ============================================================
    //  SCOPES
    // ============================================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where(function (Builder $query): void {
                $query->where('ends_at', '>', now())
                    ->orWhere(function (Builder $query): void {
                        $query->whereNull('ends_at')
                            ->whereHas('tier', fn (Builder $tierQuery): Builder => $tierQuery->where('slug', 'gratis'));
                    });
            });
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where(function (Builder $q): void {
            $q->where('status', 'expired')
                ->orWhere('ends_at', '<=', now());
        });
    }

    // ============================================================
    //  HELPERS
    // ============================================================

    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->ends_at !== null) {
            return $this->ends_at->isFuture();
        }

        return $this->tier?->slug === 'gratis';
    }

    /** Tandai membership sebagai expired. */
    public function markAsExpired(): void
    {
        $this->status = 'expired';
        $this->save();
    }
}
