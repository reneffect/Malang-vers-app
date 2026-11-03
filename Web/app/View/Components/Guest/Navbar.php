<?php

namespace App\View\Components\Guest;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Navbar extends Component
{
    public function render(): View|Closure|string
    {
        $menuItems = [
            'beranda' => ['label' => 'Beranda', 'fallback' => '/beranda'],
            'kamus' => ['label' => 'Kamus Boso Walikan', 'fallback' => '/kamus'],
            'membership' => ['label' => 'Langganan', 'fallback' => '/membership'],
        ];

        $menus = [];
        foreach ($menuItems as $routeName => $item) {
            $menus[] = [
                'label' => $item['label'],
                'href' => Route::has($routeName) ? route($routeName) : url($item['fallback']),
                'active' => request()->routeIs($routeName),
            ];
        }

        $loggedIn = auth()->check();
        $authLinks = $loggedIn
            ? [['label' => 'Dashboard', 'href' => url('/dashboard')]]
            : [
                ['label' => 'Masuk', 'href' => Route::has('login') ? route('login') : url('/login')],
                ['label' => 'Daftar', 'href' => Route::has('register') ? route('register') : url('/register')],
            ];

        return view('components.guest.navbar', [
            'loggedIn' => $loggedIn,
            'brandHref' => Route::has('home') ? route('home') : url('/'),
            'menus' => $menus,
            'authLinks' => $authLinks,
        ]);
    }
}
