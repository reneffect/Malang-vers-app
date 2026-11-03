<?php

use App\Http\Controllers\HomeController;

// Publik (guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/beranda', [HomeController::class, 'index'])->name('beranda');
Route::view('/kamus', 'guest.page', [
    'title' => 'Kamus Boso Walikan',
    'description' => 'Jelajahi kosakata Boso Walikan khas Malang.',
])->name('kamus');
Route::view('/membership', 'guest.page', [
    'title' => 'Langganan',
    'description' => 'Informasi layanan keanggotaan MalangVerse akan tersedia di sini.',
])->name('membership');
Route::view('/login', 'guest.page', [
    'title' => 'Masuk',
    'description' => 'Halaman autentikasi sedang disiapkan.',
])->name('login');
Route::view('/register', 'guest.page', [
    'title' => 'Daftar',
    'description' => 'Pendaftaran akun MalangVerse sedang disiapkan.',
])->name('register');

// Member (harus login)
// Route::middleware(['auth', 'role:member'])->group(function () {
//     Route::get('/member/dashboard', [MemberController::class, 'dashboard']);
// });

// Admin (harus login dan role admin)
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard']);
// });