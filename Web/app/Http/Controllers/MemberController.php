<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(): View
    {
        $membership = auth()->user()->activeMembership()->with('tier')->first();

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

        return view('member.member-home', compact('membership', 'recentTranslations', 'popularPhrases'));
    }
}
