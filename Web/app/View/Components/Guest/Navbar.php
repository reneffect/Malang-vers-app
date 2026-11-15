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

        $user = auth()->user();
        $loggedIn = $user !== null;

        if ($user !== null) {
            $dashboardRoute = $user->role === 'admin' ? 'admin.dashboard' : 'member.member-home';
            $dashboardFallback = $user->role === 'admin' ? '/admin/dashboard' : '/member-home';

            $authLinks = [[
                'label' => $user->name,
                'href' => Route::has($dashboardRoute) ? route($dashboardRoute) : url($dashboardFallback),
            ]];
        } else {
            $authLinks = [
                ['label' => 'Masuk', 'href' => Route::has('login') ? route('login') : url('/login')],
                ['label' => 'Daftar', 'href' => Route::has('register') ? route('register') : url('/register')],
            ];
        }

        return view('components.guest.navbar', [
            'loggedIn' => $loggedIn,
            'brandHref' => Route::has('home') ? route('home') : url('/'),
            'menus' => $menus,
            'authLinks' => $authLinks,
        ]);
    }
}
