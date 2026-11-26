<?php

use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalikanController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik (Guest & Member)
|--------------------------------------------------------------------------
*/
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/beranda', [GuestController::class, 'index'])->name('beranda');
Route::get('/kamus', [EbookController::class, 'index'])->name('kamus');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/membership', [PricingController::class, 'index'])->name('membership.public'); // Rename biar nggak bentrok

/*
|--------------------------------------------------------------------------
| Penerjemah & API Publik
|--------------------------------------------------------------------------
*/
Route::get('/walikan', [WalikanController::class, 'index'])->name('walikan');
Route::post('/translate', [WalikanController::class, 'translate'])->name('translate');
Route::get('/api/popular-phrases', [WalikanController::class, 'popularPhrases'])->name('popular.phrases');

Route::middleware('auth')->group(function () {
    Route::post('/simpan-frasa', [WalikanController::class, 'savePhrase'])->name('phrase.save');
});

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
| Pembayaran (Public / Member) - DIPISAH dari blok Admin!
|--------------------------------------------------------------------------
*/
Route::get('/pembayaran', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');

/*
|--------------------------------------------------------------------------
| Admin (SATU BLOK)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 1. Login admin (PUBLIK)
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
        // Store pakai POST /ebooks (bukan /ebooks/store) agar tidak bentrok dengan /ebooks/{ebook}
        Route::post('/ebooks', [AdminController::class, 'storeEbook'])->name('ebooks.store');
        Route::put('/ebooks/{ebook}', [AdminController::class, 'updateEbook'])->name('ebooks.update');
        Route::delete('/ebooks/{ebook}', [AdminController::class, 'deleteEbook'])->name('ebooks.destroy');

        // CRUD Users
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
        Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');

        // CRUD Membership Tiers (Paket Langganan)
        Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
        Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store');
        Route::put('/membership/{membershipTier}', [MembershipController::class, 'update'])->name('membership.update');
        Route::delete('/membership/{membershipTier}', [MembershipController::class, 'destroy'])->name('membership.destroy');
        Route::post('/membership/{membershipTier}/toggle', [MembershipController::class, 'toggle'])->name('membership.toggle');

    }); // ← Tutup middleware auth+admin
}); // ← Tutup prefix admin