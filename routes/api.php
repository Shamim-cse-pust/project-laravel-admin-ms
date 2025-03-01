<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Influencer\ProductController as InfluencerProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Common routes
Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::post('/logout', [AuthController::class, 'logout']);
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

// admin routes
Route::group(
    ['prefix' => 'admin', 'middleware' => 'auth:api'],
    function () {
        Route::get('/chart', [DashboardController::class, 'chart']);
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('/products', ProductController::class);
        Route::get('/orders/export', [OrderController::class, 'export']);
        Route::Resource('orders', OrderController::class)->only(['index','show']);
        Route::get('/permissions', [PermissionController::class, 'index']);
    }
);

// influencer routes
Route::group(
    ['prefix' => 'admin', 'middleware' => 'auth:api'],
    // ['prefix' => 'influencer'],
    function () {
        Route::get('/products', [InfluencerProductController::class, 'index']);
    }
);
