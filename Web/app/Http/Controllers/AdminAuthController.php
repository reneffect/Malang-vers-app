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
        // Kalau sudah login sebagai admin, lempar ke Kelola E-Book
        if (Auth::user()?->role === 'admin') {
            return redirect()->route('admin.ebooks'); // ✅ nama ini kini SUDAH terdaftar
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

        // ✅ Pisahkan cek role dari cek password → pesan error lebih jujur
        if (!$user) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Nama pengguna tidak ditemukan.']);
        }

        if ($user->role !== 'admin') {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Akun ini bukan administrator.']);
        }

        $ok = Auth::attempt([
            'email'    => $user->email,
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        if (!$ok) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Kata sandi salah.']);
        }

        $request->session()->regenerate();

        // ✅ Samakan dengan showLoginForm → admin.ebooks
        return redirect()->intended(route('admin.ebooks'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}