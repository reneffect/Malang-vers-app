<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('guest.page', [
            'title' => 'Beranda',
            'description' => 'Selamat datang di MalangVerse, ruang untuk mengenal dan melestarikan Boso Walikan.',
        ]);
    }
}
