<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('forget_password', [AuthController::class,'forget_password']);

});

Route::middleware('checkAuth')->prefix('home')->controller(HomeController::class)->group(function(){
    Route::get('/','index');
});
