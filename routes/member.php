<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\RegistrationController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\AnnouncementController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Member Profile Management
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

// Member Training Sessions
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', [App\Http\Controllers\Member\TrainingSessionController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\Member\TrainingSessionController::class, 'show'])->name('show');
    Route::post('/{sessionId}/register', [App\Http\Controllers\Member\TrainingSessionController::class, 'register'])->name('register');
    Route::delete('/{sessionId}/cancel', [App\Http\Controllers\Member\TrainingSessionController::class, 'cancelRegistration'])->name('cancel');
});

// Member Session Registrations
Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('index');
});

// Member Announcements
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/{id}', [AnnouncementController::class, 'show'])->name('show');
});

// Member Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/session/{sessionId}', [PaymentController::class, 'show'])->name('show');
    Route::post('/session/{sessionId}', [PaymentController::class, 'process'])->name('process');
    Route::get('/confirmation/{registrationId}', [PaymentController::class, 'confirmation'])->name('confirmation');
    Route::post('/complete/{registrationId}', [PaymentController::class, 'complete'])->name('complete');
});
