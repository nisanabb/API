<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

#SELLER API
Route::get('seller/show',[SellerController::class, 'index']);
Route::post('seller/add',[SellerController::class, 'store']);
Route::get('seller/show/{id}',[SellerController::class, 'show']);
Route::put('seller/update/{id}',[SellerController::class, 'update']);
Route::delete('seller/delete/{id}',[SellerController::class, 'destroy']);


#PRODUCT API
Route::get('product/show',[ProductController::class, 'index']);
Route::post('product/add',[ProductController::class, 'store']);
Route::get('product/show/{id}',[ProductController::class, 'show']);
Route::put('product/update/{id}',[ProductController::class, 'update']);
Route::delete('product/delete/{id}',[ProductController::class, 'destroy']);
Route::get('product/count', [ProductController::class, 'count']);
Route::get('product/filter', [ProductController::class, 'filterByPrice']);

