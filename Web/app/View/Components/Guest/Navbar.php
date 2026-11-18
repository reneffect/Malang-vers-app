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

        if ($user !== null) {
            $dashboardRoute = $user->role === 'admin' ? 'admin.dashboard' : 'member.member-home';
            $dashboardFallback = $user->role === 'admin' ? '/admin/dashboard' : '/member-home';
            $logoutRoute = $user->role === 'admin' ? 'admin.logout' : 'logout';

            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'badge' => $user->role === 'admin' ? 'ADMIN' : 'PRO',
                'dashboardHref' => Route::has($dashboardRoute) ? route($dashboardRoute) : url($dashboardFallback),
                'profileHref' => Route::has('profile.index') ? route('profile.index') : url('/pengaturan-profil'),
                'membershipHref' => Route::has('membership') ? route('membership') : url('/membership'),
                'logoutHref' => Route::has($logoutRoute) ? route($logoutRoute) : url('/logout'),
            ];
            $authLinks = [];
        } else {
            $profile = null;
            $authLinks = [
                ['label' => 'Masuk', 'href' => Route::has('login') ? route('login') : url('/login')],
                ['label' => 'Daftar', 'href' => Route::has('register') ? route('register') : url('/register')],
            ];
        }

        return view('components.guest.navbar', [
            'brandHref' => Route::has('home') ? route('home') : url('/'),
            'menus' => $menus,
            'authLinks' => $authLinks,
            'profile' => $profile,
        ]);
    }
}
