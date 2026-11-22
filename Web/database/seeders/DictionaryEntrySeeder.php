<?php

namespace Database\Seeders;

use App\Models\DictionaryEntry;
use Illuminate\Database\Seeder;

class DictionaryEntrySeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'indonesian_word' => 'Halo apa kabar',
                'walikan_word' => 'Olah apu rabak',
                'javanese_word' => 'Halo, piye kabare?',
            ],
            [
                'indonesian_word' => 'Selamat pagi',
                'walikan_word' => 'Tamelas igrap',
                'javanese_word' => 'Sugeng enjing',
            ],
            [
                'indonesian_word' => 'Terima kasih',
                'walikan_word' => 'Arimak ahsik',
                'javanese_word' => 'Matur nuwun',
            ],
            [
                'indonesian_word' => 'Apa kabar',
                'walikan_word' => 'Apu rabak',
                'javanese_word' => 'Piye kabare?',
            ],
            [
                'indonesian_word' => 'Selamat siang',
                'walikan_word' => 'Tamelas gainis',
                'javanese_word' => 'Sugeng siang',
            ],
            [
                'indonesian_word' => 'Sampai jumpa',
                'walikan_word' => 'Apmias apmuj',
                'javanese_word' => 'Nganti ketemu',
            ],
            [
                'indonesian_word' => 'Selamat malam',
                'walikan_word' => 'Tamelas malam',
                'javanese_word' => 'Sugeng dalu',
            ],
            [
                'indonesian_word' => 'Bagaimana kabarmu',
                'walikan_word' => 'Adimainak rubamuh',
                'javanese_word' => 'Piye kabarmu?',
            ],
        ];

        foreach ($entries as $entry) {
            DictionaryEntry::updateOrCreate(
                ['indonesian_word' => $entry['indonesian_word']],
                $entry,
            );
        }
    }
}
