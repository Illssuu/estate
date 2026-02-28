<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlatController;

use Illuminate\Support\Facades\Route;

// Главная страница с квартирами
Route::get('/', [ProductController::class, 'index'])->name('flats.index');


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

Route::get('/flats', [ProductController::class, 'index'])->name('flats.index');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Главная админки
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // Управление квартирами
    Route::get('/flats', [AdminController::class, 'flats'])->name('flats');
    
    // Управление пользователями
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/flats/create', [FlatController::class, 'create'])->name('flats.create'); // ЭТОТ НУЖЕН
    Route::post('/flats', [FlatController::class, 'store'])->name('flats.store');

});