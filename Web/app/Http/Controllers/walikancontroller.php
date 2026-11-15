<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalikanController extends Controller
{
    public function index()
    {
        $recentTranslations = [
            [
                'original' => 'Halo, apa kabar? Semoga sehat selalu!',
                'translated' => 'Olah, apu rabak? agomeh tahes ulalas!',
                'date' => '2 menit yang lalu',
            ],
            [
                'original' => 'Selamat pagi, bagaimana kabarmu hari ini?',
                'translated' => 'Tamelas igrap, adimainak rubamuh irih inih?',
                'date' => '15 menit yang lalu',
            ],
            [
                'original' => 'Terima kasih sudah berkunjung ke sini',
                'translated' => 'Arimak ahsik udah jingunkub ek inis',
                'date' => '1 jam yang lalu',
            ],
        ];

        $popularPhrases = [
            ['id' => 'Halo apa kabar', 'walikan' => 'Olah apu rabak'],
            ['id' => 'Selamat pagi', 'walikan' => 'Tamelas igrap'],
            ['id' => 'Terima kasih', 'walikan' => 'Arimak ahsik'],
            ['id' => 'Apa kabar', 'walikan' => 'Apu rabak'],
            ['id' => 'Selamat siang', 'walikan' => 'Tamelas gainis'],
            ['id' => 'Sampai jumpa', 'walikan' => 'Apmias apmuj'],
        ];

        return view('walikan.index', compact('recentTranslations', 'popularPhrases'));
    }

    public function translate(Request $request)
    {
        $text = $request->input('text', '');
        $direction = $request->input('direction', 'id_to_walikan');

        $translated = $this->convertWalikan($text);

        return response()->json([
            'success' => true,
            'translated' => $translated,
            'original' => $text,
        ]);
    }

    public function popularPhrases()
    {
        $phrases = [
            ['id' => 'Halo apa kabar', 'walikan' => 'Olah apu rabak'],
            ['id' => 'Selamat pagi', 'walikan' => 'Tamelas igrap'],
            ['id' => 'Terima kasih', 'walikan' => 'Arimak ahsik'],
        ];

        return response()->json($phrases);
    }

    private function convertWalikan($text)
    {
        // Logika konversi Boso Walikan (Malang)
        // Setiap kata dibalik per suku kata
        $words = explode(' ', $text);
        $result = [];

        foreach ($words as $word) {
            $result[] = strrev($word);
        }

        return implode(' ', $result);
    }
}
