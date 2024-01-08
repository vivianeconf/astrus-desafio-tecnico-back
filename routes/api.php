<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('/user', [UserController::class, 'create']);
Route::get('/user/{user}', [UserController::class, 'read']);
Route::put('/user/{user}', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'delete']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function()
{
    Route::post('/products', [ProductController::class, 'create']);
    Route::get('/products/{product}', [ProductController::class, 'read']);
    Route::get('/products', [ProductController::class, 'all']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'delete']);
});

