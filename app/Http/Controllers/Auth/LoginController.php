<?php

namespace App\Http\Controllers\Auth; // ← PERBAIKAN: Namespace sesuai folder Auth

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // Default role adalah member
            'is_active' => true,
        ]);

        return redirect()->route('login');
    }

    /**
     * Proses login untuk Member/Guest
     */
    public function loginMember(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cegah akun admin masuk lewat pintu member
            if ($user->role === 'admin') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun Admin tidak diizinkan login melalui halaman ini.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('member.member-home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle Firebase Google Sign-In Callback
     */
    public function handleFirebaseCallback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'email' => 'required|email',
            'google_id' => 'required|string',
        ]);

        $name = !empty($validated['name']) ? $validated['name'] : explode('@', $validated['email'])[0];

        $user = User::where('google_id', $validated['google_id'])
            ->orWhere('email', $validated['email'])
            ->first();

        if ($user) {
            if (!$user->google_id) {
                $user->google_id = $validated['google_id'];
                $user->save();
            }
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $validated['email'],
                'google_id' => $validated['google_id'],
                'password' => Hash::make(Str::random(32)),
                'role' => 'member',
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $redirectUrl = $user->role === 'admin'
            ? route('admin.dashboard')
            : route('member.member-home');

        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl,
        ]);
    }

    /**
     * Proses login khusus Admin
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cegah user biasa masuk lewat pintu admin
            if ($user->role !== 'admin') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akses ditolak. Hanya akun Admin yang diizinkan.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial admin salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout umum untuk member dan admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Alias logout admin.
     */
    public function logoutAdmin(Request $request)
    {
        return $this->logout($request);
    }
}
