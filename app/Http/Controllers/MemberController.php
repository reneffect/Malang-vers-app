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
                'original' => 'Ojo lali nribun nak Kanjuruhan, Sam!',
                'translated' => 'Jangan lupa nonton di tribun Stadion Kanjuruhan, Mas!',
                'date' => '2 menit yang lalu',
            ],
            [
                'original' => 'Nalot sak ndayak, ojir e entek nggo ngombe kopi.',
                'translated' => 'Tolak banyak-banyak, uangnya habis buat minum kopi.',
                'date' => '15 menit yang lalu',
            ],
            [
                'original' => 'Gedang goreng anget rek, enak temenan.',
                'translated' => 'Pisang goreng hangat kawan, enak sekali.',
                'date' => '1 jam yang lalu',
            ],
        ];

        $popularPhrases = [
            ['id' => 'Saya', 'walikan' => 'Ayas'],
            ['id' => 'Kamu', 'walikan' => 'Umak'],
            ['id' => 'Uang', 'walikan' => 'Ojir'],
            ['id' => 'Keren Sekali', 'walikan' => 'Mbois Ilakes'],
            ['id' => 'Marah', 'walikan' => 'Ngaram'],
            ['id' => 'Berangkat', 'walikan' => 'Ladub'],
            ['id' => 'Sehat Walafiat', 'walikan' => 'Tahes Komlet'],
        ];

        return view('member.member-home', compact('membership', 'recentTranslations', 'popularPhrases'));
    }
}
