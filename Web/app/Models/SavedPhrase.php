<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedPhrase extends Model
{
    protected $table = 'saved_phrases';

    protected $fillable = [
        'indonesian', 'walikan', 'category', 'usage_count', 'is_active',
    ];

    protected $casts = [
        'usage_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopePopular($query)
    {
        return $query->where('is_active', true)->orderByDesc('usage_count');
    }
}
