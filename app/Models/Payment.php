<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'transaction_id',
        'payment_provider',
        'payment_method',
        'provider_reference',
        'amount',
        'fee',
        'net_amount',
        'status',
        'settlement_status',
        'payment_url',
        'qr_code_url',
        'qr_string',
        'expires_at',
        'paid_at',
        'gateway_response',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'fee'              => 'decimal:2',
        'net_amount'       => 'decimal:2',
        'expires_at'       => 'datetime',
        'paid_at'          => 'datetime',
        'gateway_response' => 'array',
    ];

    // ============================================================
    //  RELASI
    // ============================================================

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // ============================================================
    //  SCOPES
    // ============================================================

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeSuccess(Builder $query): Builder
    {
        return $query->where('status', 'success');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired');
    }

    // ============================================================
    //  HELPERS
    // ============================================================

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' || ($this->expires_at && $this->expires_at->isPast());
    }
}
