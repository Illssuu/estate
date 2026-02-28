<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;              
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegister(){
        return view('auth.register');
    }
    
    // Показать админку
    public function showAdmin(){
        return view('admin.index');
    }   
    
    // Обработка регистрации
    public function register(Request $request){  // Убрали RegisterUserRequest
        // Валидация данных прямо здесь
        $data = $request->validate([
            'login' => 'required|min:6|unique:users|alpha_num',
            'password' => 'required|min:8|confirmed',
            'name' => 'required|regex:/^[\p{Cyrillic} ]+$/u',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^\+7\d{10}$/'
        ]);
        
        // Создание пользователя
        $user = User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        
        // Редирект на страницу с квартирами
        return redirect()->route('flats.index')->with('success', 'Регистрация прошла успешно');
    }

    // Показать форму входа
    public function showLogin(){
        return view('auth.login');
    }
    
    // Обработка входа
    public function login(Request $request){
        // Валидация логина и пароля
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);
        
        // Попытка авторизации
        if (Auth::attempt($credentials)) {
            // Обновляем сессию
            $request->session()->regenerate();
            
            // Проверяем роль пользователя
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.index');
            }
            
            return redirect()->route('flats.index')->with('success', 'Успешный вход');
        }
        
        return back()->withErrors([
            'login' => 'Неверные учетные данные'
        ])->onlyInput('login');
    }
    
    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Вы успешно вышли из системы');
    }
}