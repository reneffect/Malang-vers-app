<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'membership_tier_id',
        'transaction_item_id',
        'started_at',
        'ends_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(
            MembershipTier::class,
            'membership_tier_id',
            'id_membership_tier',
        );
    }

    public function getExpiresAtAttribute()
    {
        return $this->ends_at;
    }
}
