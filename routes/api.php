<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas públicas: cadastro/login e consultas (GET)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ->parameters() mantém o nome do parâmetro igual ao do controller
// (sem ele o Laravel geraria {autore})
Route::apiResource('autores', AutorController::class)->only(['index', 'show'])->parameters(['autores' => 'autor']);
Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::apiResource('livros', LivroController::class)->only(['index', 'show']);

// Rotas protegidas pelo Sanctum: exigem o header "Authorization: Bearer {token}"
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('autores', AutorController::class)->except(['index', 'show'])->parameters(['autores' => 'autor']);
    Route::apiResource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::apiResource('livros', LivroController::class)->except(['index', 'show']);
    Route::apiResource('usuarios', UserController::class)->parameters(['usuarios' => 'user']);
});
