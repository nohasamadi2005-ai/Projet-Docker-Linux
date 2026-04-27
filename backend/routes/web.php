<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/',         fn() => redirect('/login'));
Route::get('/login',    fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth');
Route::get('/home',     fn() => view('home'))->middleware('auth');