<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;

// 1. GUEST ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// 2. PROTECTED ROUTES
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Resources (IMPORTANT: this defines your route names)
    Route::resource('rooms', RoomController::class);
    Route::resource('tenants', TenantController::class);

    // FIX: This generates reservations.index (NOT rentals.index)
    Route::resource('reservations', ReservationController::class);

    Route::resource('payments', PaymentController::class);

    // Extra routes
    Route::post('/payments/{payment}/mark-as-paid', [PaymentController::class, 'markAsPaid'])
        ->name('payments.mark-paid');

    Route::get('/tenants/{tenant}/payments', [PaymentController::class, 'tenantPayments'])
        ->name('payments.tenant');
});