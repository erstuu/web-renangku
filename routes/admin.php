<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" and "role:admin" middleware group.
|
*/

// Admin Dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Admin Coach Management Routes
Route::prefix('coaches')->name('coaches.')->group(function () {
    // Menampilkan daftar coach yang menunggu approval
    Route::get('/pending', function () {
        // TODO: Implement admin coach approval management
        return view('admin.coaches.pending');
    })->name('pending');

    // Approve coach
    Route::post('/{id}/approve', function ($id) {
        // TODO: Implement coach approval logic
    })->name('approve');

    // Reject coach
    Route::post('/{id}/reject', function ($id) {
        // TODO: Implement coach rejection logic
    })->name('reject');

    // Daftar semua coach
    Route::get('/', function () {
        // TODO: Implement coaches list
        return view('admin.coaches.index');
    })->name('index');
});

// Admin Member Management Routes
Route::prefix('members')->name('members.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement members list
        return view('admin.members.index');
    })->name('index');
});

// Admin Training Sessions Management
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement training sessions management
        return view('admin.training-sessions.index');
    })->name('index');
});

// Admin Announcements Management
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement announcements management
        return view('admin.announcements.index');
    })->name('index');

    Route::get('/create', function () {
        // TODO: Implement announcement creation
        return view('admin.announcements.create');
    })->name('create');

    Route::post('/', function () {
        // TODO: Implement announcement store
    })->name('store');
});
