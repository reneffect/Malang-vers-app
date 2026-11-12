<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.guest', [
            'title' => 'Penerjemahan Boso Walikan',
            'description' => 'Jelajahidan ubah kosakata Kiwalan khas Areama ke Bahasa Indonesia secara instan, akurat, dan interaktiflangsung dari perambana desktop anda.',
        ]);
    }
}
