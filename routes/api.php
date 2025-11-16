<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckIsAdmin;

// Buat Dapetin Semua Data User
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Buat Register User Baru
Route::post('/register', 
[UserController::class,'register']);


// Buat Login User
Route::post('/login', [UserController::class, 'login']);

// Buat Logout User
Route::post('/logout', [UserController::class, 'logout']) -> middleware('auth:sanctum');

//Produk

//Get Semua Produk
Route::get('/products', [ProductController::class, 'getAll']);

//Get Specific Produk
Route::get('/products/{id}', [ProductController::class, 'getSpecific']);

//Post Produk
Route::post('/products', [ProductController::class, 'create'])-> middleware(['auth:sanctum', CheckIsAdmin::class]);

//Update Specific Produk
Route::put('/products/{id}',[ProductController::class, 'editSpecific'])-> middleware(['auth:sanctum', CheckIsAdmin::class]);

//Delete Specific Produk
Route::delete('/products/{id}',[ProductController::class, 'deleteSpecific'])-> middleware(['auth:sanctum', CheckIsAdmin::class]);

