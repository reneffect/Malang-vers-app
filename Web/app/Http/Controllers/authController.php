<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authController extends Controller
{
    public function loginMember(Request $request) {
    if (auth()->attempt($request->only('email', 'password'))) {
        // Cek apakah dia admin yang nyoba login di form member?
        if (auth()->user()->role == 'admin') {
            auth()->logout(); // Tendang keluar
            return back()->withErrors(['email' => 'Admin harus login di halaman admin!']);
        }
        return redirect('/dashboard');
    }
    return back()->withErrors(['email' => 'Kredensial salah']);
}

public function loginAdmin(Request $request) {
    if (auth()->attempt($request->only('email', 'password'))) {
        // Cek apakah dia beneran admin?
        if (auth()->user()->role != 'admin') {
            auth()->logout(); // Tendang keluar
            return back()->withErrors(['email' => 'Kamu bukan admin!']);
        }
        return redirect('/admin/dashboard');
    }
    return back()->withErrors(['email' => 'Kredensial salah']);
}
}
