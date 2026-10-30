<?php

use Illuminate\Support\Facades\Route;
Use Illuminate\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});

// Publik (guest)

Route::get('/', [HomeController::class, 'index']);

// Member (harus login)
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard']);
});

// Admin (harus login dan role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
});
