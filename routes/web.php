<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuilderController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/builder', [BuilderController::class, 'getBuilderPage']);

Route::get('/login', [AuthController::class, 'getLoginPage'])->middleware('guest')->name('login');

Route::get('/register', [AuthController::class, 'getRegisterPage'])->middleware('guest');

Route::get('/my-account', [AuthController::class, 'getMyAccountPage'])->middleware('auth');

Route::post('/api/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/api/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('/api/log-out', [AuthController::class, 'logOut'])->middleware('auth');