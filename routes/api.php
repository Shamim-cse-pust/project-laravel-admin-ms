<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Laravel\Passport\Http\Middleware\CheckScopes;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Influencer\LinkController;
use App\Http\Controllers\Influencer\ProductController as InfluencerProductController;
use App\Http\Controllers\Checkout\LinkController as CheckoutLinkController;
use App\Http\Controllers\Checkout\OrderController as CheckoutOrderController;
use App\Http\Controllers\Influencer\StatsController;

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
    // ['prefix' => 'admin', 'middleware' => ['auth:api', CheckScopes::class . ':admin']],
    ['prefix' => 'admin', 'middleware' => ['auth:api']],
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
    ['prefix' => 'influencer', 'middleware' => 'auth:api'],
    function () {
        Route::get('/products', [InfluencerProductController::class, 'index']);
        Route::post('links', [LinkController::class, 'store']);
        Route::get('stats', [StatsController::class, 'index']);
        Route::get('rankings', [StatsController::class, 'rankings']);
    }
);

Route::group(
    ['prefix' => 'checkout', 'middleware' => 'auth:api'],
    function () {
        Route::get('links/{code}', [CheckoutLinkController::class, 'show']);
        Route::post('orders', [CheckoutOrderController::class, 'store']);
        Route::post('orders/confirm', [CheckoutOrderController::class, 'confirm']);
    }
);
