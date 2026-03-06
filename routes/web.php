<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Главная страница с квартирами
Route::get('/', [ProductController::class, 'index'])->name('flats.index');

// Регистрация и авторизация
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Защищенные маршруты (только для авторизованных)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Личный кабинет
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/favorites', [ProfileController::class, 'favorites'])->name('favorites');
        Route::post('/favorites/toggle/{flatId}', [ProfileController::class, 'toggleFavorite'])->name('favorites.toggle');
        Route::get('/applications', [ProfileController::class, 'applications'])->name('applications');
        Route::post('/applications', [ProfileController::class, 'storeApplication'])->name('applications.store');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});

// // Детальная страница квартиры (публичная)
// Route::get('/flats/{id}', [ProductController::class, 'show'])->name('flats.show');

// // Админка (только для администраторов)
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
//     // Главная админки
//     Route::get('/', [AdminController::class, 'index'])->name('index');
    
//     // Управление квартирами
//     Route::get('/flats', [AdminController::class, 'flats'])->name('flats');
//     Route::get('/flats/create', [FlatController::class, 'create'])->name('flats.create');
//     Route::post('/flats', [FlatController::class, 'store'])->name('flats.store');
    
//     // Управление пользователями
//     Route::get('/users', [AdminController::class, 'users'])->name('users');
// });

// Отдельный маршрут для входа в админку
Route::get('/admin', [AuthController::class, 'showAdmin'])
    ->middleware(['auth', 'admin'])
    ->name('admin.show');