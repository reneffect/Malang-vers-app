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
        $user = auth()->user();

        $menus = [
            [
                'label' => 'Translator',
                'href' => $user ? route('member.member-home') : route('home'),
                'active' => request()->routeIs('member.member-home') || request()->routeIs('home') || request()->routeIs('beranda') || request()->routeIs('walikan'),
            ],
            [
                'label' => 'E-Book',
                'href' => Route::has('kamus') ? route('kamus') : url('/kamus'),
                'active' => request()->routeIs('kamus*'),
            ],
            [
                'label' => 'Membership',
                'href' => Route::has('membership.public') ? route('membership.public') : (Route::has('pricing') ? route('pricing') : url('/membership')),
                'active' => request()->routeIs('membership*') || request()->routeIs('pricing'),
            ],
        ];

        if ($user !== null) {
            $dashboardRoute = $user->role === 'admin' ? 'admin.dashboard' : 'member.member-home';
            $dashboardFallback = $user->role === 'admin' ? '/admin/dashboard' : '/member-home';
            $logoutRoute = $user->role === 'admin' ? 'admin.logout' : 'logout';

            $badge = 'PRO';
            if ($user->role === 'admin') {
                $badge = 'ADMIN';
            } elseif ($user->activeMembership && $user->activeMembership->tier) {
                $badge = strtoupper($user->activeMembership->tier->name);
            }

            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'badge' => $badge,
                'avatarUrl' => $user->avatar ? asset('storage/'.$user->avatar) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80',
                'dashboardHref' => Route::has($dashboardRoute) ? route($dashboardRoute) : url($dashboardFallback),
                'profileHref' => Route::has('profile.index') ? route('profile.index') : url('/pengaturan-profil'),
                'membershipHref' => Route::has('membership.public') ? route('membership.public') : url('/membership'),
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
            'brandHref' => $user ? route('member.member-home') : route('home'),
            'menus' => $menus,
            'authLinks' => $authLinks,
            'profile' => $profile,
        ]);
    }
}
