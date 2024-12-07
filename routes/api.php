<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::group(
            ['prefix' => '/profile'],
            function () {
                Route::get('', [ProfileController::class, 'showProfile']);
                Route::put('/edit', [ProfileController::class, 'editProfile']);
                Route::put('/password/update', [ProfileController::class, 'changePassword']);
                Route::delete('/profile/delete', [ProfileController::class, 'destroyProfile']);
            }
        );
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
    }
);
