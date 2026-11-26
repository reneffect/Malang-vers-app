<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationHistory extends Model
{
    protected $table = 'translation_histories';

    protected $fillable = [
        'original_text', 'translated_text', 'direction',
        'user_id', 'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest()->limit($limit);
    }
}
