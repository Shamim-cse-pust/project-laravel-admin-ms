<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::get('/chart', [DashboardController::class, 'chart']);
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('/products', ProductController::class);
        Route::get('/orders/export', [OrderController::class, 'export']);
        Route::Resource('orders', OrderController::class)->only(['index','show']);
        Route::apiResource('users', UserController::class);
        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::group(
            ['prefix' => '/profile'],
            function () {
                Route::get('', [ProfileController::class, 'showProfile']);
                Route::put('/edit', [ProfileController::class, 'editProfile']);
                Route::put('/password/update', [ProfileController::class, 'changePassword']);
                Route::delete('/profile/delete', [ProfileController::class, 'destroyProfile']);
            }
        );
    }
);
