<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH İŞLEMLERİ
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// BLOG İŞLEMLERİ 
Route::get('/posts', [PostController::class, 'index']); 
Route::get('/posts/{post}', [PostController::class, 'show']); //BLOG POST SLUG veya ID

// ADMİN İŞLEMLERİ SANCTUM-AUTH
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});
