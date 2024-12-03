<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::apiResource('users', UserController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/update/user', [UserController::class, 'updateProfile']);
    Route::put('/update/password', [UserController::class, 'updatePassword']);
    Route::delete('/profile/delete', [UserController::class, 'destroyProfile']);
});
