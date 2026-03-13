<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BuybackController;

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
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::post('/settings/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});

// Детальная страница квартиры (публичная)
Route::get('/flats/{id}', [ProductController::class, 'show'])->name('flats.show');

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
// Детальная страница квартиры
Route::get('/flats/{id}', [ProductController::class, 'show'])->name('flats.show');

Route::get('/flats', [ProductController::class, 'index'])->name('flats.index');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    

    // Главная админки
  // Главная админки
  Route::get('/', [AdminController::class, 'index'])->name('index');
        
  Route::resource('flats', FlatController::class);

});
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/profile/applications', [ApplicationController::class, 'myApplications'])->name('profile.applications');

Route::get('/buyback', [BuybackController::class, 'index'])->name('buyback.index');
// Отправка заявки на возврат
Route::post('/buyback/request', [BuybackController::class, 'store'])->name('buyback.request');

// Админка - заявки
/////////////////////////////////////
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::post('/application/{id}/status', [AdminController::class, 'updateApplicationStatus'])->name('application.status');
    Route::post('/buyback/{id}/status', [AdminController::class, 'updateBuybackStatus'])->name('buyback.status');
    Route::get('/application/{id}', [AdminController::class, 'showApplication'])->name('application.show');
    Route::get('/buyback/{id}', [AdminController::class, 'showBuyback'])->name('buyback.show');
    Route::delete('/application/{id}', [AdminController::class, 'destroyApplication'])->name('application.destroy');
    Route::delete('/buyback/{id}', [AdminController::class, 'destroyBuyback'])->name('buyback.destroy');
});