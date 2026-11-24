<?php

use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
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
Route::get('/walikan', [WalikanController::class, 'index'])->name('walikan');
Route::post('/translate', [WalikanController::class, 'translate'])->name('translate');

Route::middleware('auth')->group(function () {
    Route::post('/simpan-frasa', [WalikanController::class, 'savePhrase'])->name('phrase.save');
});

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
| Member (Terautentikasi & WAJIB Role Member)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'member'])->group(function () {
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

    // 1. Login admin (PUBLIK, tidak pakai middleware auth/admin)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');

    // 2. Fitur admin (HARUS LOGIN + ROLE ADMIN)
    Route::middleware(['auth', 'admin'])->group(function () {

        // Halaman utama
        Route::get('/', [AdminController::class, 'ebooks'])->name('dashboard');
        Route::get('/ebooks', [AdminController::class, 'ebooks'])->name('ebooks');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('transaksi');
        Route::get('/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // CRUD E-Book
        Route::post('/ebooks/store', [AdminController::class, 'storeEbook'])->name('ebooks.store');
        Route::put('/ebooks/{ebook}', [AdminController::class, 'updateEbook'])->name('ebooks.update');
        Route::delete('/ebooks/{ebook}', [AdminController::class, 'deleteEbook'])->name('ebooks.destroy');
        Route::post('/ebooks/{ebook}/toggle', [AdminController::class, 'toggleEbook'])->name('ebooks.toggle');

        // CRUD Membership Tier
        Route::post('/tiers/store', [AdminController::class, 'storeTier'])->name('tiers.store');
        Route::put('/tiers/{tier}', [AdminController::class, 'updateTier'])->name('tiers.update');
        Route::delete('/tiers/{tier}', [AdminController::class, 'deleteTier'])->name('tiers.destroy');
        Route::post('/tiers/{tier}/toggle', [AdminController::class, 'toggleTier'])->name('tiers.toggle');

        // CRUD Users
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
        Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');

        // Membership Tiers (Paket Langganan)
        Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
        Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store');
        Route::put('/membership/{membershipTier}', [MembershipController::class, 'update'])->name('membership.update');
        Route::delete('/membership/{membershipTier}', [MembershipController::class, 'destroy'])->name('membership.destroy');

    });
});
