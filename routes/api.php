<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('dashboard', [DashboardController::class, 'index']);

    Route::get('students/export', [StudentReportController::class, 'showWorkout']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);
    
    Route::post('students', [StudentController::class, 'store'])->middleware('validate.limit.student');
    Route::get('students', [StudentController::class, 'index']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::get('students/{id}/workouts', [StudentController::class, 'getWorkouts']);
    Route::get('students/{id}', [StudentController::class, 'show']);

    Route::post('workouts', [WorkoutController::class, 'store']);

    // rotas privadas
});

Route::post('users', [UserController::class, 'store']);

Route::post('login', [AuthController::class, 'store']);

// rota pública
