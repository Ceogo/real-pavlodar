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

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/realties', [RealtiesController::class, 'store']);
    Route::put('/realties/{id}', [RealtiesController::class, 'update']);

    // Feed and preferences routes
    Route::post('/favorites/{id}', [FeedController::class, 'toggleFavorite']);
    Route::post('/preferences', [FeedController::class, 'updatePreferences']);
});
