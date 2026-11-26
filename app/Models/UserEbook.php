<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEbook extends Model
{
    protected $table = 'user_ebooks';

    protected $fillable = [
        'user_id',
        'ebook_id',
        'acquisition_type',
        'membership_id',
        'price_paid',
        'transaction_id',
        'acquired_at',
    ];

    protected $casts = [
        'price_paid'  => 'decimal:2',
        'acquired_at' => 'datetime',
    ];

    // ============================================================
    //  RELASI
    // ============================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // ============================================================
    //  HELPERS
    // ============================================================

    public function isPurchased(): bool
    {
        return $this->acquisition_type === 'purchased';
    }

    public function isClaimed(): bool
    {
        return $this->acquisition_type === 'claimed';
    }
}
