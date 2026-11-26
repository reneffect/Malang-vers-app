<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DictionaryEntry extends Model
{
    protected $fillable = [
        'indonesian_word',
        'walikan_word',
        'javanese_word',
    ];

    public function scopePopular($query)
    {
        // Kalau di tabel ada kolom 'popularity' atau 'views', bisa diurutkan di sini.
        // Sementara kita urutkan berdasarkan ID atau nama aja.
        return $query->orderByDesc('id');
    }
}
