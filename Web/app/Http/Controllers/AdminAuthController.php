<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email ATAU nama (username)
        $user = User::where('email', $credentials['username'])
                    ->orWhere('name', $credentials['username'])
                    ->first();

        if (!$user || !Auth::attempt(
            ['email' => $user->email, 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Nama pengguna atau kata sandi salah.']);
        }

        // Cek role
        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'username' => 'Akun ini bukan admin. Silakan login sebagai member.',
            ]);
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