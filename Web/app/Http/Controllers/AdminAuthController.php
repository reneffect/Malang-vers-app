<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email ATAU nama (username)
        $user = User::where('email', $credentials['username'])
            ->orWhere('name', $credentials['username'])
            ->first();

        if ($user?->role !== 'admin' || ! Auth::attempt(
            ['email' => $user->email, 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Nama pengguna atau kata sandi salah.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
