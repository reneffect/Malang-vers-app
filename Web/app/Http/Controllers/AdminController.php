<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'totalKamus' => Ebook::count(),
            'totalMember' => User::where('role', 'member')->count(),
            'langgananAktif' => Membership::where('status', 'active')->count(),
            'transaksiQris' => 0,
        ]);
    }

    public function ebooks(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function verifikasi(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function membership(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function users(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function transaksi(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }
}
