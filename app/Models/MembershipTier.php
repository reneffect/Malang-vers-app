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
        'ebook_access',
        'features',
        'is_active',
        'is_featured',
        'sort_order',
        'order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'features' => 'array',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'price' => 'decimal:2',
        'translation_quota' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

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
