<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk pemilih role
Route::get('/auth/role-selector', function () {
    return view('auth.role-selector');
})->name('role.selector');

// Routes untuk dashboard berdasarkan role (sementara menggunakan closure)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/coach/dashboard', function () {
    return view('coach.dashboard');
})->name('coach.dashboard');

Route::get('/member/dashboard', function () {
    return view('member.dashboard');
})->name('member.dashboard');

require __DIR__ . '/auth.php';
