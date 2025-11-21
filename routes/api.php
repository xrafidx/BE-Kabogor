<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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
Route::patch('/products/{id}',[ProductController::class, 'editSpecific'])-> middleware(['auth:sanctum', CheckIsAdmin::class]);

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
Route::put('/order/{id}',[OrderController::class, 'editOrder'])->middleware(['auth:sanctum', CheckIsAdmin::class]);



// REVIEWS

// Create Review (User dan Admin)
Route::post('/reviews/',[ReviewController::class,'createReview'])->middleware(['auth:sanctum']);
// Delete Review (Admin)
Route::delete('/reviews/{id}',[ReviewController::class,'deleteReview'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Get semua review 
Route::get('/reviews/',[ReviewController::class,'getAllReview'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Get specific review
Route::get('/reviews/{id}',[ReviewController::class,'getSpecificReview'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
// Change state review (hidden or show) (Admin)
Route::patch('/reviews/{id}',[ReviewController::class,'changeStateReview'])->middleware(['auth:sanctum', CheckIsAdmin::class]);


// Dashboard
// Get Data Sepanjang Masa
Route::get('/dashboard/',[DashboardController::class, 'getData'])->middleware(['auth:sanctum', CheckIsAdmin::class]);
Route::post('/cta',[DashboardController::class, 'incrementCta']);
