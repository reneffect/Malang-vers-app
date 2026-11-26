<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTier extends Model
{
    protected $table = 'membership_tiers';

    protected $primaryKey = 'id_membership_tier';

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'duration_days',
        'price',
        'benefits',
        'monthly_price',
        'yearly_price',
        'translation_quota',
        'daily_credits',
        'credits_per_word',
        'is_unlimited_translate',
        'ebook_access',
        'ebook_access_level',
        'claimable_ebooks',
        'preview_pages',
        'show_ads',
        'show_pro_badge',
        'features',
        'is_active',
        'is_featured',
        'sort_order',
        'order',
    ];

    protected $casts = [
        'benefits'               => 'array',
        'features'               => 'array',
        'monthly_price'          => 'decimal:2',
        'yearly_price'           => 'decimal:2',
        'price'                  => 'decimal:2',
        'translation_quota'      => 'integer',
        'daily_credits'          => 'integer',
        'credits_per_word'       => 'integer',
        'claimable_ebooks'       => 'integer',
        'preview_pages'          => 'integer',
        'is_active'              => 'boolean',
        'is_featured'            => 'boolean',
        'is_unlimited_translate' => 'boolean',
        'show_ads'               => 'boolean',
        'show_pro_badge'         => 'boolean',
    ];

    // ============================================================
    //  HELPERS
    // ============================================================

    /** Paket ini apakah unlimited translate? */
    public function isUnlimitedTranslate(): bool
    {
        return (bool) $this->is_unlimited_translate;
    }

    /** Kredit harian efektif (fallback ke 100 untuk Gratis). */
    public function effectiveDailyCredits(): int
    {
        return $this->daily_credits ?? 100;
    }

    /** Biaya kredit per kata (fallback ke 5). */
    public function effectiveCreditsPerWord(): int
    {
        return $this->credits_per_word ?? 5;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Relasi ke memberships (user yang berlangganan tier ini)
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'membership_tier_id', 'id_membership_tier');
    }

    // Helper: jumlah pelanggan aktif
    public function getActiveMembersCountAttribute()
    {
        return $this->memberships()
            ->where('status', 'active')
            ->count();
    }
}
