<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $user = auth()->user();

        if ($user !== null) {
            $dashboardRoute = $user->role === 'admin' ? 'admin.dashboard' : 'member.member-home';

            return redirect()->route($dashboardRoute);
        }

        return view('guest.guest', [
            'title' => 'Penerjemahan Boso Walikan',
            'description' => 'Jelajahidan ubah kosakata Kiwalan khas Areama ke Bahasa Indonesia secara instan, akurat, dan interaktiflangsung dari perambana desktop anda.',
        ]);
    }
}
