<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::post('dashboard', [DashboardController::class, 'index']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    // rotas privadas
});

Route::post('users', [UserController::class, 'store']);

Route::post('login', [AuthController::class, 'store']);

// rota pública
