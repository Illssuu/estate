<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Главная страница с квартирами
Route::get('/', [ProductController::class, 'index'])->name('flats');
Route::get('/register',[AuthController::class, 'showRegister'])->name('register.show');//Показывает форму регистрации

Route::post('/register',[AuthController::class, 'register'])->name('register');//Создает нового пользователя
Route::get('/login',[AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login',[AuthController::class, 'login'])->name('login');//авторизует пользователя

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin', [AuthController::class, 'showAdmin'])
    ->middleware(['auth', 'admin'])
    ->name('admin.show');
// Детальная страница квартиры
Route::get('/flats/{id}', [ProductController::class, 'show'])->name('flats.show');

