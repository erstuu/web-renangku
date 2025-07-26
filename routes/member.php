<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
|
| Here is where you can register member routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" and "role:member" middleware group.
|
*/

// Member Dashboard
Route::get('/dashboard', function () {
    return view('member.dashboard');
})->name('member.dashboard');

// Member Profile Management
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement member profile view
        return view('member.profile.show');
    })->name('show');

    Route::get('/edit', function () {
        // TODO: Implement member profile edit
        return view('member.profile.edit');
    })->name('edit');

    Route::put('/', function () {
        // TODO: Implement member profile update
    })->name('update');
});

// Member Training Sessions
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement available training sessions for members
        return view('member.training-sessions.index');
    })->name('index');

    Route::get('/{id}', function ($id) {
        // TODO: Implement training session detail
        return view('member.training-sessions.show', compact('id'));
    })->name('show');
});

// Member Session Registrations
Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement member registrations history
        return view('member.registrations.index');
    })->name('index');

    Route::post('/training-sessions/{sessionId}', function ($sessionId) {
        // TODO: Implement member registration to training session
    })->name('store');

    Route::delete('/{id}', function ($id) {
        // TODO: Implement member registration cancellation
    })->name('destroy');
});

// Member Announcements
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement member announcements view
        return view('member.announcements.index');
    })->name('index');

    Route::get('/{id}', function ($id) {
        // TODO: Implement announcement detail
        return view('member.announcements.show', compact('id'));
    })->name('show');
});
