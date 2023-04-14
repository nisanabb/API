<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;

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
Route::get('seller/show',[SellerController::class, 'index']);
Route::post('seller/add',[SellerController::class, 'store']);
Route::get('seller/show/{id}',[SellerController::class, 'show']);
Route::put('seller/update/{id}',[SellerController::class, 'update']);
Route::delete('seller/delete/{id}',[SellerController::class, 'destroy']);



