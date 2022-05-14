<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


    // public routes
// Route::prefix('api')->group(function(){

    Route::post('/login', [UserController::class,'login'])->name('login.api');
    Route::middleware('auth:api')->group(function(){
        Route::post('/logout', [UserController::class,'logout'])->name('logout.api');
        Route::get('/category', [CategoryController::class,'index']);
        Route::get('/products/{id?}', [ProductController::class,'index']);
        // return $request->user();
    });
// });
