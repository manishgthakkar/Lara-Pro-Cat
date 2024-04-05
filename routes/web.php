<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);
Route::post('delete-category', [CategoryController::class,'destroy']);
Route::get("category/removeAll", [CategoryController::class, 'removeAll'])->name('category.removeAll');

Route::resource('products', ProductController::class);
Route::post('delete-product', [ProductController::class,'destroy']);
Route::get("product/removeAll", [ProductController::class, 'removeAll'])->name('product.removeAll');