<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


// Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::post('/dashboard/clear-cache', [DashboardController::class, 'clearCache'])->name('dashboard.clear-cache');

    // Resourceful routes for Penumpang and User
    Route::resource('penumpang', PenumpangController::class);
    Route::resource('users', UserController::class)->middleware('can:admin');

    // Additional penumpang routes
    Route::patch('penumpang/{penumpang}/status', [PenumpangController::class, 'updateStatus'])->name('penumpang.update-status');
    Route::get('penumpang-stats', [PenumpangController::class, 'stats'])->name('penumpang.stats');
    Route::get('penumpang-recent', [PenumpangController::class, 'recent'])->name('penumpang.recent');
    Route::patch('penumpang/bulk-update-status', [PenumpangController::class, 'bulkUpdateStatus'])->name('penumpang.bulk-update-status');
    Route::get('penumpang-export', [PenumpangController::class, 'export'])->name('penumpang.export');

    // Additional user routes for optimized operations
    Route::middleware('can:admin')->group(function () {
        Route::delete('users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
        Route::patch('users/bulk-update-role', [UserController::class, 'bulkUpdateRole'])->name('users.bulk-update-role');
        Route::get('users/stats', [UserController::class, 'stats'])->name('users.stats');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    });
});
