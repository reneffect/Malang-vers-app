<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationPhraseUsage extends Model
{
    protected $fillable = [
        'translation_history_id',
        'indonesian_word',
        'walikan_word',
    ];

    public function translationHistory(): BelongsTo
    {
        return $this->belongsTo(TranslationHistory::class);
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query
            ->select('indonesian_word', 'walikan_word')
            ->selectRaw('COUNT(*) as usage_count')
            ->groupBy('indonesian_word', 'walikan_word')
            ->orderByDesc('usage_count')
            ->orderBy('indonesian_word');
    }

    public function getIndonesianDisplayAttribute(): string
    {
        return mb_convert_case($this->indonesian_word, MB_CASE_TITLE, 'UTF-8');
    }

    public function getWalikanDisplayAttribute(): string
    {
        return mb_convert_case($this->walikan_word, MB_CASE_TITLE, 'UTF-8');
    }
}
