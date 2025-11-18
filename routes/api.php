<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

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


// CRUD Data Sendiri (Profil)

// dapetin data profile diri sendiri
Route::get('/profile',[ProfileController::class, 'getMyData'])-> middleware('auth:sanctum');

//edit data profile diri sendiri
Route::put('/profile',[ProfileController::class, 'editMyData'])-> middleware('auth:sanctum');



// CRUD Akun User (KHUSUS ADMIN)

// Dapetin Semua Data Users
Route::get('/users',[AccountController::class, 'getAllUser'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Dapetin Data Users Tertentu
Route::get('/user/{id}',[AccountController::class, 'getSpecificUser'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Edit Data Users Tertentu
Route::put('/user/{id}',[AccountController::class, 'editSpecificUser'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Hapus Data Users Tertentu
Route::delete('/users/{id}',[AccountController::class, 'deleteSpecificUser'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Bikin Data User Baru
Route::post('/user',[AccountController::class, 'createUser'])->middleware(['auth:sanctum', CheckIsAdmin::class]);



// ORDER CRUD
// Get Order untuk user dan admin
Route::get('/orders',[OrderController::class, 'showAllOrder'])->middleware(['auth:sanctum']);
// Get Specific Order
Route::get('/order/{id}',[OrderController::class, 'showSpecificOrder'])->middleware(['auth:sanctum']);
// Create Order
Route::post('/order',[OrderController::class, 'createOrder'])->middleware(['auth:sanctum']);
// Delete Order
Route::delete('/order/{id}',[OrderController::class, 'deleteOrder'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Change State Order
Route::patch('/order/{id}',[OrderController::class, 'editState'])->middleware(['auth:sanctum']);
// Edit Order

//EDIT ORDER BUGGY!
// Route::put('/order/{id}',[OrderController::class, 'editOrder'])->middleware(['auth:sanctum', CheckIsAdmin::class]);


// HASIL TESTING
// Admin token:2|pfDZQw7JZImkTZ8DNVKaZL7PnBXAi3Ofr5okuGJ2f7120621
// User token:3|n9unKHXEnfLmmnSlEobugZPxQm8YYAsdMmqGA4Ue4ccf3729
// User token:4|4zZFGM5uu4av7hZcHBPv2W4Jlg2WMF5G0ACNIxL43c19983d


// Pengamatan gua:
// Create Order Berhasil buat user biasa.
// Create Order Berhasil buat admin.

// Get Specific Order bisa buat user biasa
// Get Specific ORder bisa buat admin

// Get All Orders berhasil buat admin
// Get All Orders berhasil buat user juga

// Delete Work buat admin aja (intended)

// Update status worked semuanya dan sesuai.

