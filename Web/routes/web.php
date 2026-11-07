<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik (guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/beranda', [GuestController::class, 'index'])->name('beranda');

Route::view('/kamus', 'guest.Guest', [
    'title'       => 'Kamus Boso Walikan',
    'description' => 'Jelajahi kosakata Boso Walikan khas Malang.',
])->name('kamus');

Route::view('/membership', 'guest.Guest', [
    'title'       => 'Langganan',
    'description' => 'Informasi layanan keanggotaan MalangVerse akan tersedia di sini.',
])->name('membership');

Route::view('/login', 'guest.Guest', [
    'title'       => 'Masuk',
    'description' => 'Halaman autentikasi sedang disiapkan.',
])->name('login');

Route::view('/register', 'guest.Guest', [
    'title'       => 'Daftar',
    'description' => 'Pendaftaran akun MalangVerse sedang disiapkan.',
])->name('register');

// Endpoint penerjemah (dipanggil via fetch POST dari halaman guest)
Route::post('/terjemah', fn () => response()->json([
    'hasil' => 'Fitur terjemahan belum tersedia.',
]))->name('terjemah');