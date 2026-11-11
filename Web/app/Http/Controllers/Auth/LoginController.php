<?php

namespace App\Http\Controllers\Auth; // ← PERBAIKAN: Namespace sesuai folder Auth

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← TAMBAHAN: Wajib untuk Auth::
use App\Models\User; // ← TAMBAHAN: Untuk create user baru
use Illuminate\Support\Facades\Hash; // ← TAMBAHAN: Untuk hash password
use Illuminate\Validation\Rules\Password; // ← TAMBAHAN: Untuk validasi password

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login Member
     */
    public function showMemberLogin()
    {
        return view('auth.member-login');
    }

    /**
     * Tampilkan halaman login Admin
     */
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Tampilkan form registrasi
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Default role adalah member
            'is_active' => true,
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        // Redirect ke dashboard member
        return redirect()->route('member.dashboard');
    }

    /**
     * Proses login untuk Member/Guest
     */
    public function loginMember(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cegah akun admin masuk lewat pintu member
            if ($user->role === 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Admin tidak diizinkan login melalui halaman ini.'
                ])->onlyInput('email');
            }

            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->onlyInput('email');
    }

    /**
     * Proses login khusus Admin
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cegah user biasa masuk lewat pintu admin
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akses ditolak. Hanya akun Admin yang diizinkan.'
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial admin salah.'
        ])->onlyInput('email');
    }
}