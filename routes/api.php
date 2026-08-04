<?php

use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum');
    Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
    Route::get('/verify-email', [AuthenticationController::class, 'verifyEmail']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return response()->json(['message' => 'Admin dashboard']);
        });

        Route::apiResource('/admin/users', UserManagementController::class)->except(['index']);
    });

    Route::middleware('role:support_agent')->get('/support/dashboard', function () {
        return response()->json(['message' => 'Support agent dashboard']);
    });

    Route::middleware('role:customer')->get('/customer/dashboard', function () {
        return response()->json(['message' => 'Customer dashboard']);
    });

    Route::apiResource('/conversations', \App\Http\Controllers\Api\Chat\ConversationController::class);
    Route::apiResource('/conversations.messages', \App\Http\Controllers\Api\Chat\MessageController::class)->shallow();
    Route::get('/unread', [\App\Http\Controllers\Api\Chat\UnreadController::class, 'index']);
    Route::post('/unread/{conversation}', [\App\Http\Controllers\Api\Chat\UnreadController::class, 'conversation']);
    Route::get('/online-status', [\App\Http\Controllers\Api\Chat\OnlineStatusController::class, 'index']);
    Route::post('/online-status', [\App\Http\Controllers\Api\Chat\OnlineStatusController::class, 'update']);
    Route::get('/typing-status', [\App\Http\Controllers\Api\Chat\TypingStatusController::class, 'index']);
    Route::post('/typing-status', [\App\Http\Controllers\Api\Chat\TypingStatusController::class, 'update']);
    Route::get('/search', \App\Http\Controllers\Api\Chat\SearchController::class);
});
