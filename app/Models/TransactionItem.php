<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    protected $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'item_type',
        'ebook_id',
        'membership_tier_id',
        'item_name_snapshot',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
    ];

    // ============================================================
    //  RELASI
    // ============================================================

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class, 'membership_tier_id', 'id_membership_tier');
    }

    // ============================================================
    //  HELPERS
    // ============================================================

    public function isEbook(): bool
    {
        return $this->item_type === 'ebook';
    }

    public function isMembership(): bool
    {
        return $this->item_type === 'membership_tier';
    }
}
