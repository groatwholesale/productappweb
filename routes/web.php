<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/','login');

Auth::routes(['register'=>false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('category', CategoryController::class)->except(['show']);
Route::resource('products', ProductController::class)->except(['show']);
Route::get('category/lists',[CategoryController::class,'lists'])->name('category.lists');
Route::get('products/lists',[ProductController::class,'lists'])->name('products.lists');
Route::get('orders',[OrderController::class,'index'])->name('order.index');
Route::get('orders/lists',[OrderController::class,'lists'])->name('order.lists');