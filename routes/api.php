<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware('checkAuth')->prefix('dashboard')->controller(HomeController::class)->group(function(){
    Route::get('/','index');

    Route::controller(ProductController::class)->prefix('products')->group(function(){
        Route::get('/','index');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::post('delete/{id}','delete');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function(){
        Route::get('/','index');
        Route::post('/store','store');
        Route::post('/update/{id}','update');
        Route::post('/delete/{id}','delete');
    });

    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('/','index');
        Route::post('/store','store');
        Route::post('/update/{id}','update');
        Route::post('/delete/{id}','delete');
    });


});
