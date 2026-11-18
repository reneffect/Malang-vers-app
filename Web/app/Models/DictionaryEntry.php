<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DictionaryEntry extends Model
{
    protected $table = 'dictionary_entries';

    protected $fillable = [
        'indonesian_word',
        'walikan_word',
        'javanese_word',
    ];
}
