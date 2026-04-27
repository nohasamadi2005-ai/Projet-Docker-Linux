<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/',         fn() => redirect('/login'));
Route::get('/login',    fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth');
Route::get('/home',     fn() => view('home'))->middleware('auth');

Route::middleware(['auth', 'isMedecin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/patient/accueil', fn() => view('home'));
    Route::get('/medecin/dashboard', fn() => view('home'));
});