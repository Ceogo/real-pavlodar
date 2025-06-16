<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/properties', [PropertyController::class, 'index'])->name('admin.properties.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('admin.properties.create')->middleware('role:administrator');
    Route::post('/properties', [PropertyController::class, 'store'])->name('admin.properties.store')->middleware('role:administrator');
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit'])->name('admin.properties.edit');
    Route::put('/properties/{id}', [PropertyController::class, 'update'])->name('admin.properties.update');
    Route::post('/properties/{id}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve')->middleware('role:moderator|administrator');
    Route::post('/properties/{id}/reject', [PropertyController::class, 'reject'])->name('admin.properties.reject')->middleware('role:moderator|administrator');
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('admin.properties.destroy')->middleware('role:administrator');

    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/requests', [RequestController::class, 'index'])->name('admin.requests.index');
        Route::put('/requests/{id}', [RequestController::class, 'update'])->name('admin.requests.update');
    });
});
