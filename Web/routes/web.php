<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\Auth\LoginController; // ← INI YANG BENAR (Import Controller)
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik (Guest)
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

// Endpoint penerjemah (dipanggil via fetch POST dari halaman guest)
Route::post('/terjemah', fn () => response()->json([
    'hasil' => 'Fitur terjemahan belum tersedia.',
]))->name('terjemah');

/*
|--------------------------------------------------------------------------
| Autentikasi (Login & Register)
|--------------------------------------------------------------------------
*/

// --- REGISTER ---
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// --- LOGIN MEMBER ---
Route::get('/login', [LoginController::class, 'showMemberLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginMember']);

// --- LOGIN ADMIN ---
Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'loginAdmin']);