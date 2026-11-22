<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipTier extends Model
{
    protected $table = 'membership_tiers';

    protected $primaryKey = 'id_membership_tier';

    protected $fillable = [
        'name', 'description', 'duration_days', 'price', 'benefits',
        'monthly_price', 'yearly_price', 'badge', 'is_recommended',
        'is_active', 'order',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'price' => 'decimal:2',
        'benefits' => 'array',
        'monthly_price' => 'integer',
        'yearly_price' => 'integer',
        'is_recommended' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function features()
    {
        return $this->hasMany(MembershipTierFeature::class)->orderBy('order');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
