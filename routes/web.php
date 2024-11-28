<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
return 'shamim';
});
Route::get('/index',[UserController::class,'index']);

