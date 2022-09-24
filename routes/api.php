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
    Route::post('/opt_verification', [UserController::class,'opt_verification'])->name('opt_verification.api');
    Route::middleware('auth:api')->group(function(){
        Route::get('/get_profile', [UserController::class,'get_profile'])->name('get_profile.api');
        Route::post('/update_profile', [UserController::class,'update_profile'])->name('update_profile.api');
        Route::post('/logout', [UserController::class,'logout'])->name('logout.api');
        Route::get('/category', [CategoryController::class,'index']);
        Route::post('/products', [ProductController::class,'index']);
        Route::get('/topproduct', [ProductController::class,'topproduct']);
        Route::get('/products/{id}', [ProductController::class,'show']);
        Route::post('/addtocart', [ProductController::class,'addtocart']);
        Route::get('/getaddtocart_products', [ProductController::class,'getaddtocart_products']);
        Route::post('/updatecartproducts', [ProductController::class,'updatecartproducts']);
        Route::post('/deletecartproducts', [ProductController::class,'deletecartproducts']);
        Route::post('/addorders', [ProductController::class,'buyproduct']);
        Route::get('/getorders', [ProductController::class,'getbuyproduct']);
        Route::get('/getbanners', [ProductController::class,'banner']);
        Route::get('/get_address', [ProductController::class,'get_address']);
    });
// });
