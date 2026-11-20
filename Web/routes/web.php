<?php

use App\Http\Controllers\AdminAuthController;
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
Route::get('/kamus', [BookController::class, 'index'])->name('kamus');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/membership', [PricingController::class, 'index'])->name('membership');

/*
|--------------------------------------------------------------------------
| Penerjemah & API Publik
|--------------------------------------------------------------------------
*/
Route::post('/translate', [WalikanController::class, 'translate'])->name('translate');
Route::get('/api/popular-phrases', [WalikanController::class, 'popularPhrases'])->name('popular.phrases');

/*
|--------------------------------------------------------------------------
| Autentikasi Member: Register & Login
|--------------------------------------------------------------------------
*/
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login', [LoginController::class, 'showMemberLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginMember']);

/*
|--------------------------------------------------------------------------
| Member (Terautentikasi)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/member-home', [MemberController::class, 'index'])->name('member.member-home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/pengaturan-profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/pengaturan-profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/ubah-kata-sandi', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
});

/*
|--------------------------------------------------------------------------
| Admin (SATU BLOK, URL & Nama Route Sudah Bersih!)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 1. Form login admin (Bisa diakses siapa saja)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');

    // 2. Fitur Admin (Hanya untuk yang sudah login)
    Route::middleware('auth')->group(function () {
        
        // Default: Akses /admin langsung ke Kelola E-Book
        Route::get('/', [AdminController::class, 'ebooks'])->name('dashboard');
        
        // Route spesifik (Otomatis jadi URL: /admin/ebooks, Nama: admin.ebooks)
        Route::get('/ebooks', [AdminController::class, 'ebooks'])->name('ebooks');
        Route::get('/membership', [AdminController::class, 'membership'])->name('membership');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('transaksi');
        Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
        
        // Logout admin
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});