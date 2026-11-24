<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'user_id',
        'tier_id',
        'start_date',
        'end_date',
        'status',
        'billing_cycle', // 'monthly' atau 'yearly'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'tier_id');
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }
}
