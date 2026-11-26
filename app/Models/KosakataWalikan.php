<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KosakataWalikan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kosakata_walikan';

    protected $fillable = [
        'kata_walikan',
        'kata_asli',
        'arti',
        'bahasa_asal',
        'kelas_kata',
        'kategori_kasar',
        'tingkat_formal',
        'tipe_walikan',
        'catatan',
    ];

    protected $casts = [
        'kategori_kasar' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // === SCOPES UNTUK FILTER UMUM ===

    public function scopeBahasa(Builder $query, string $bahasa): Builder
    {
        return $query->where('bahasa_asal', $bahasa);
    }

    public function scopeKelas(Builder $query, string $kelas): Builder
    {
        return $query->where('kelas_kata', $kelas);
    }

    public function scopeSopan(Builder $query): Builder
    {
        return $query->where('kategori_kasar', false);
    }

    public function scopeKasar(Builder $query): Builder
    {
        return $query->where('kategori_kasar', true);
    }

    public function scopeHurufAwal(Builder $query, string $huruf): Builder
    {
        return $query->where('kata_walikan', 'LIKE', strtoupper($huruf).'%');
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('kata_walikan', 'LIKE', "%{$keyword}%")
                ->orWhere('kata_asli', 'LIKE', "%{$keyword}%")
                ->orWhere('arti', 'LIKE', "%{$keyword}%");
        });
    }

    // === ACCESSOR ===

    public function getIsKasarAttribute(): bool
    {
        return $this->kategori_kasar === true;
    }

    public function getLabelKelasKataAttribute(): string
    {
        return match ($this->kelas_kata) {
            'n' => 'Kata Benda',
            'v' => 'Kata Kerja',
            'adj' => 'Kata Sifat',
            'adv' => 'Kata Keterangan',
            'pron' => 'Kata Ganti',
            'num' => 'Angka',
            'part' => 'Partikel',
            'prop' => 'Nama Diri',
            'phrase' => 'Frasa',
            default => '-',
        };
    }
}
