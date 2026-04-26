<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Authentifié
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',       [AuthController::class, 'logout']);
    Route::get('/me',            [AuthController::class, 'me']);
    Route::get('/slots',         [SlotController::class, 'index']);
    Route::get('/appointments',  [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);

    // Médecin seulement
    Route::middleware('isMedecin')->group(function () {
        Route::post('/slots',            [SlotController::class, 'store']);
        Route::delete('/slots/{id}',     [SlotController::class, 'destroy']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    });
});