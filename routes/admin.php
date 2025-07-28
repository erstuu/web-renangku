<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DataChangeRequestController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin Coach Management Routes
Route::prefix('coaches')->name('coaches.')->group(function () {
    Route::get('/', [CoachController::class, 'index'])->name('index');
    Route::get('/pending', [CoachController::class, 'pending'])->name('pending');
    Route::get('/create', [CoachController::class, 'create'])->name('create');
    Route::post('/', [CoachController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CoachController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [CoachController::class, 'update'])->name('update');
    Route::get('/{id}', [CoachController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [CoachController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [CoachController::class, 'reject'])->name('reject');
    Route::post('/{id}/toggle-status', [CoachController::class, 'toggleStatus'])->name('toggle-status');
    Route::delete('/{id}', [CoachController::class, 'destroy'])->name('destroy');
});

// Admin Member Management Routes
Route::prefix('members')->name('members.')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::get('/create', [MemberController::class, 'create'])->name('create');
    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MemberController::class, 'edit'])->name('edit');
    Route::get('/{id}', [MemberController::class, 'show'])->name('show');
    Route::put('/{id}/update', [MemberController::class, 'update'])->name('update');
    Route::post('/{id}/update-membership', [MemberController::class, 'updateMembershipStatus'])->name('update-membership');
    Route::post('/{id}/toggle-status', [MemberController::class, 'toggleStatus'])->name('toggle-status');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('destroy');
});

// Admin Training Sessions Management
Route::prefix('training-sessions')->name('training-sessions.')->group(function () {
    Route::get('/', [TrainingSessionController::class, 'index'])->name('index');
    Route::get('/create', [TrainingSessionController::class, 'create'])->name('create');
    Route::post('/', [TrainingSessionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [TrainingSessionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TrainingSessionController::class, 'update'])->name('update');
    Route::get('/{id}', [TrainingSessionController::class, 'show'])->name('show');
    Route::post('/{id}/toggle-status', [TrainingSessionController::class, 'toggleStatus'])->name('toggle-status');
    Route::delete('/{id}', [TrainingSessionController::class, 'destroy'])->name('destroy');
});

// Admin Announcements Management
Route::prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('store');
    Route::get('/{id}', [AnnouncementController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AnnouncementController::class, 'update'])->name('update');
    Route::post('/{id}/toggle-publish', [AnnouncementController::class, 'togglePublishStatus'])->name('toggle-publish');
    Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('destroy');
});

// Admin Data Change Requests Management
Route::prefix('data-change-requests')->name('data-change-requests.')->group(function () {
    Route::get('/', [DataChangeRequestController::class, 'index'])->name('index');
    Route::get('/{id}', [DataChangeRequestController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [DataChangeRequestController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [DataChangeRequestController::class, 'reject'])->name('reject');
});
