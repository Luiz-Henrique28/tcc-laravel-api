<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rotas da API RESTful de Catálogo de Produtos.
| Rotas GET são públicas, rotas de escrita exigem autenticação via Sanctum.
|
*/

// Autenticação
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// Categorias — leitura pública, escrita autenticada
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store'])
    ->middleware('auth:sanctum');
Route::put('/categories/{category}', [CategoryController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->middleware('auth:sanctum');

// Produtos — leitura pública, escrita autenticada
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store'])
    ->middleware('auth:sanctum');
Route::put('/products/{product}', [ProductController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->middleware('auth:sanctum');
