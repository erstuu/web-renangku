<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Landing page
Route::get('/', function () {
    // Jika user sudah login, redirect ke dashboard sesuai role
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'coach':
                return redirect()->route('coach.dashboard');
            case 'member':
                return redirect()->route('member.dashboard');
            default:
                Auth::logout();
                return redirect('/')->with('error', 'Role tidak valid. Silakan login kembali.');
        }
    }

    return view('welcome');
});

// Route untuk pemilih role - hanya untuk guest (belum login)
Route::get('/auth/role-selector', function () {
    return view('auth.role-selector');
})->middleware('guest')->name('role.selector');

/*
|--------------------------------------------------------------------------
| Role-based Route Groups
|--------------------------------------------------------------------------
|
| Routes are separated by role and loaded from dedicated files.
| Each group has appropriate middleware for authentication and authorization.
|
*/

// Admin Routes - prefix /admin
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(base_path('routes/admin.php'));

// Coach Routes - prefix /coach  
Route::prefix('coach')
    ->middleware(['auth', 'role:coach'])
    ->group(base_path('routes/coach.php'));

// Member Routes - prefix /member
Route::prefix('member')
    ->middleware(['auth', 'role:member'])
    ->group(base_path('routes/member.php'));

// Authentication Routes
require __DIR__ . '/auth.php';
