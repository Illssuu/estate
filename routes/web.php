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
    
// routes/web.php

   
  Route::get('/', [AdminController::class, 'index'])->name('index');
        
  Route::resource('flats', FlatController::class);
  Route::get('/users', [AdminController::class, 'users'])->name('users');
 // routes/web.php
 Route::post('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.update-role');
 Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

});