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
        'monthly_price',
        'yearly_price',
        'benefits',
        'translation_quota',
        'ebook_access',
        'features',
        'badge',
        'is_active',
        'is_featured',
        'is_recommended',
        'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'translation_quota' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // app/Models/MembershipTier.php
public function memberships()
{
    return $this->hasMany(Membership::class, 'membership_tier_id');
}

    public function getActiveMembersCountAttribute(): int
    {
        return $this->memberships()
            ->where('status', 'active')
            ->count();
    }
}