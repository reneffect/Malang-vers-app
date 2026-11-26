<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ebook extends Model
{
    public const STANDARD_CLAIM_MAX_PRICE = 35000;

    protected $table = 'buku_digital';

    protected $fillable = [
        'judul',
        'kode_url',
        'penulis',
        'deskripsi',
        'kategori',
        'lokasi_sampul',
        'lokasi_pratinjau',
        'lokasi_berkas',
        'jumlah_halaman',
        'terjual',
        'harga',
        'harga_lisensi',
        'can_be_claimed',
        'sudah_diterbitkan',
        'is_bundle',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'harga_lisensi' => 'decimal:2',
        'terjual' => 'integer',
        'jumlah_halaman' => 'integer',
        'is_bundle' => 'boolean',
        'can_be_claimed' => 'boolean',
        'sudah_diterbitkan' => 'boolean',
    ];

    // ============================================================
    //  SCOPES
    // ============================================================

    public function scopeRegular(Builder $query): Builder
    {
        return $query->where('is_bundle', false)->where('sudah_diterbitkan', true);
    }

    public function scopeBundle(Builder $query): Builder
    {
        return $query->where('is_bundle', true)->where('sudah_diterbitkan', true);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('sudah_diterbitkan', true);
    }

    public function scopeClaimable(Builder $query): Builder
    {
        return $query->where('can_be_claimed', true)
            ->whereRaw('COALESCE(NULLIF(harga_lisensi, 0), harga) <= ?', [self::STANDARD_CLAIM_MAX_PRICE])
            ->where('sudah_diterbitkan', true);
    }

    public function licensePrice(): float
    {
        return (float) ($this->harga_lisensi > 0 ? $this->harga_lisensi : $this->harga);
    }

    public function isClaimableByStandard(): bool
    {
        return $this->can_be_claimed
            && $this->licensePrice() <= self::STANDARD_CLAIM_MAX_PRICE;
    }

    // ============================================================
    //  RELASI
    // ============================================================

    /** Semua kepemilikan ebook ini oleh user. */
    public function owners(): HasMany
    {
        return $this->hasMany(UserEbook::class, 'ebook_id');
    }
}
