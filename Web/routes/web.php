<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalikanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/beranda', [GuestController::class, 'index'])->name('beranda');

Route::view('/kamus', 'guest.guest', [
    'title' => 'Kamus Boso Walikan',
    'description' => 'Jelajahi kosakata Boso Walikan khas Malang.',
])->name('kamus');

Route::get('/membership', [PricingController::class, 'index'])->name('membership');

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

Route::middleware('auth')->group(function () {
    Route::get('/member-home', [MemberController::class, 'index'])->name('member.member-home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// --- LOGIN ADMIN ---
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [LoginController::class, 'logoutAdmin'])->name('admin.logout');
});

Route::post('/translate', [WalikanController::class, 'translate'])->name('translate');
Route::get('/api/popular-phrases', [WalikanController::class, 'popularPhrases'])->name('popular.phrases');
Route::get('/kamus', [BookController::class, 'index'])->name('kamus');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

Route::middleware('auth')->group(function () {
    Route::get('/pengaturan-profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/pengaturan-profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/ubah-kata-sandi', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
});
