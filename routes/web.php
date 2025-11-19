<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManajemenProduk;
use App\Http\Controllers\ManajemenProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard',[DashboardController::class, 'dashboardData']);
Route::get('/manajemenproduk',[ManajemenProdukController::class, 'getProduk']);



