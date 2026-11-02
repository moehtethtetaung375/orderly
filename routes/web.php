
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

// ========================================
// Public Routes: Guest Only
// ========================================

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});


// ========================================
// Authenticated Routes
// Admin and User
// ========================================

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ====================================
    // Notification Routes
    // ====================================

    // Display all notifications
    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

    // Mark one notification as read
    Route::patch('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notifications.read');

    // Mark all notifications as read
    Route::patch('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead'
    ])->name('notifications.readAll');


    // ====================================
    // Profile Routes
    // ====================================

    // View and edit profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Update name and email
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Change password
    Route::put('/profile/password', [
        ProfileController::class,
        'updatePassword'
    ])->name('profile.password.update');


    // ====================================
    // Item Routes: Admin and User
    // ====================================

    Route::resource('items', ItemController::class)
        ->whereNumber('item');


    // ====================================
    // Order Routes: Admin and User
    // ====================================

    Route::resource('orders', OrderController::class)
        ->whereNumber('order');

});
