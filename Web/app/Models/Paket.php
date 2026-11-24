<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'name', 'tagline', 'monthly_price', 'yearly_price',
        'translation_quota', 'ebook_access', 'features',
        'is_active', 'active_members',
    ];

    protected $casts = [
        'features' => 'array',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
