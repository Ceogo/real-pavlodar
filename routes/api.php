<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\RealtiesController;
use App\Http\Controllers\V1\FeedController;


Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/realties', [RealtiesController::class, 'index']);
    Route::get('/realties/{id}', [RealtiesController::class, 'show']);
    Route::get('/feed', [FeedController::class, 'index']);
});

// Register middleware aliases
app()->bind('admin', \App\Http\Middleware\AdminMiddleware::class);
app()->bind('moderator', \App\Http\Middleware\ModeratorMiddleware::class);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Realty routes for authenticated users
    Route::post('/realties', [RealtiesController::class, 'store']);
    Route::put('/realties/{id}', [RealtiesController::class, 'update']);

    // Feed and preferences routes
    Route::post('/favorites/{id}', [FeedController::class, 'toggleFavorite']);
    Route::post('/preferences', [FeedController::class, 'updatePreferences']);

    // Moderator-only routes
    Route::middleware('moderator')->group(function () {
        // Realty moderation routes
        Route::get('/moderation/realties', [RealtiesController::class, 'index']);
        Route::put('/moderation/realties/{id}/status', [RealtiesController::class, 'updateStatus']);
    });

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // User management
        Route::post('/users', [AuthController::class, 'store']);
        Route::delete('/users/{id}', [AuthController::class, 'destroy']);

        // Realty management
        Route::delete('/realties/{id}', [RealtiesController::class, 'destroy']);

        // Statistics and applications
        Route::get('/admin/statistics', [RealtiesController::class, 'statistics']);
        Route::get('/admin/applications', [RealtiesController::class, 'applications']);
        Route::get('/admin/applications/export', [RealtiesController::class, 'exportApplications']);
    });
});
