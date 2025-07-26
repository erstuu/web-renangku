<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Routes untuk login - middleware 'guest' agar user yang sudah login tidak bisa akses
Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

// Routes login per role
Route::get('/user/admin/login', [LoginController::class, 'createAdmin'])
    ->middleware('guest')
    ->name('login.admin.form');

Route::get('/user/coach/login', [LoginController::class, 'createCoach'])
    ->middleware('guest')
    ->name('login.coach.form');

Route::get('/user/member/login', [LoginController::class, 'createMember'])
    ->middleware('guest')
    ->name('login.member.form');

// Routes login spesifik per role
Route::post('/user/admin/login', [LoginController::class, 'storeAdmin'])
    ->middleware('guest')
    ->name('login.admin.store');

Route::post('/user/coach/login', [LoginController::class, 'storeCoach'])
    ->middleware('guest')
    ->name('login.coach.store');

Route::post('/user/member/login', [LoginController::class, 'storeMember'])
    ->middleware('guest')
    ->name('login.member.store');

// Route untuk logout
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Routes untuk registrasi berdasarkan role
Route::get('/user/member/register', [RegisterController::class, 'createMember'])
    ->middleware('guest')
    ->name('register.member.form');

Route::get('/user/coach/register', [RegisterController::class, 'createCoach'])
    ->middleware('guest')
    ->name('register.coach.form');

// Route untuk proses registrasi dengan method spesifik
Route::post('/user/member/register', [RegisterController::class, 'storeMember'])
    ->middleware('guest')
    ->name('register.member.store');

Route::post('/user/coach/register', [RegisterController::class, 'storeCoach'])
    ->middleware('guest')
    ->name('register.coach.store');

// Redirect admin register ke login admin
Route::get('/user/admin/register', function () {
    return redirect('/user/admin/login')->with('error', 'Admin tidak dapat mendaftar. Silakan login dengan akun admin yang sudah ada.');
})->middleware('guest');

// Route fallback untuk backward compatibility (opsional, bisa dihapus nanti)
Route::get('/register', function () {
    return redirect()->route('register.member.form');
})->middleware('guest')
    ->name('register');

Route::post('/user/{role}/register', [RegisterController::class, 'store'])
    ->where('role', 'member|coach')
    ->middleware('guest')
    ->name('register.store');
