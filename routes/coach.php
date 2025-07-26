<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coach\DashboardController;
use App\Http\Controllers\Coach\ProfileController;

/*
|--------------------------------------------------------------------------
| Coach Routes
|--------------------------------------------------------------------------
|
| Here is where you can register coach routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" and "role:coach" middleware group.
|
*/

// Coach Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('coach.dashboard');

// Coach Profile Management
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/setup', [ProfileController::class, 'setup'])->name('setup');
    Route::post('/setup', [ProfileController::class, 'store'])->name('store');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

// Coach Training Sessions Management
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement coach training sessions list
        return view('coach.training-sessions.index');
    })->name('index');

    Route::get('/create', function () {
        // TODO: Implement training session creation
        return view('coach.training-sessions.create');
    })->name('create');

    Route::post('/', function () {
        // TODO: Implement training session store
    })->name('store');

    Route::get('/{id}/edit', function ($id) {
        // TODO: Implement training session edit
        return view('coach.training-sessions.edit', compact('id'));
    })->name('edit');

    Route::put('/{id}', function ($id) {
        // TODO: Implement training session update
    })->name('update');

    Route::delete('/{id}', function ($id) {
        // TODO: Implement training session delete
    })->name('destroy');
});

// Coach Session Registrations Management
Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/', function () {
        // TODO: Implement coach registrations view
        return view('coach.registrations.index');
    })->name('index');

    Route::post('/{id}/approve', function ($id) {
        // TODO: Implement registration approval
    })->name('approve');

    Route::post('/{id}/reject', function ($id) {
        // TODO: Implement registration rejection
    })->name('reject');
});
