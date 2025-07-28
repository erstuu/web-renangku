<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coach\DashboardController;
use App\Http\Controllers\Coach\ProfileController;
use App\Http\Controllers\Coach\TrainingSessionController;
use App\Http\Controllers\Coach\RegistrationController;
use App\Http\Controllers\Coach\DataChangeRequestController;
use App\Http\Controllers\Coach\EarningsReportController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Coach Profile Management
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/setup', [ProfileController::class, 'setup'])->name('setup');
    Route::post('/setup', [ProfileController::class, 'store'])->name('store');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

// Coach Training Sessions Management
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', [TrainingSessionController::class, 'index'])->name('index');
    Route::get('/create', [TrainingSessionController::class, 'create'])->name('create');
    Route::post('/', [TrainingSessionController::class, 'store'])->name('store');
    Route::get('/{trainingSession}/edit', [TrainingSessionController::class, 'edit'])->name('edit');
    Route::put('/{trainingSession}', [TrainingSessionController::class, 'update'])->name('update');
    Route::delete('/{trainingSession}', [TrainingSessionController::class, 'destroy'])->name('destroy');
});

// Coach Session Registrations Management
Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('index');
    Route::post('/{sessionRegistration}/approve', [RegistrationController::class, 'approve'])->name('approve');
    Route::post('/{sessionRegistration}/reject', [RegistrationController::class, 'reject'])->name('reject');
    Route::post('/{sessionRegistration}/mark-absent', [RegistrationController::class, 'markAbsent'])->name('mark-absent');
});

// Coach Data Change Requests
Route::prefix('data-change-requests')->name('data-change-requests.')->group(function () {
    Route::get('/', [DataChangeRequestController::class, 'index'])->name('index');
    Route::get('/create', [DataChangeRequestController::class, 'create'])->name('create');
    Route::post('/', [DataChangeRequestController::class, 'store'])->name('store');
    Route::get('/{dataChangeRequest}', [DataChangeRequestController::class, 'show'])->name('show');
});

// Coach Earnings Report
Route::prefix('earnings')->name('earnings.')->group(function () {
Route::get('/report', [EarningsReportController::class, 'index'])->name('report');
Route::get('/report/print', [EarningsReportController::class, 'print'])->name('report.print');
});
