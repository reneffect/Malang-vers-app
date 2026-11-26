<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 */
class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'transaction_code',
        'total_amount',
        'status',
        'paid_at',
        'expires_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // ============================================================
    //  RELASI
    // ============================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function proof(): HasOne
    {
        return $this->hasOne(PaymentProof::class);
    }

    // ============================================================
    //  SCOPES
    // ============================================================

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    // ============================================================
    //  HELPERS
    // ============================================================

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function markAsPaid(): void
    {
        $this->status = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    /** Generate kode transaksi unik format: MV-YYYYMMDD-RANDOM */
    public static function generateCode(): string
    {
        return 'MV-'.now()->format('Ymd').'-'.strtoupper(substr(uniqid(), -6));
    }
}
