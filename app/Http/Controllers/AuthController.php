<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegister(){
        return view ('auth.register');
    }
    public function showAdmin(){
        return view ('admin.admin');
    }   
    //Обработка регистрации
     public function register(RegisterUserRequest $request){
        // Валидация данных в Form Request
        $data = $request->validate([
            'login'=>'required|min:6|unique:users|alpha_num', // уникальный логин
            'password'=>'required|min:8|confirmed',// пароль с подтверждением
            'name'=>'required|regex:/^[\p{Cyrillic} ]+$/u',// только кириллица и пробелы
            'email'=>'required|email|unique:users',
            'phone'=>'required|regex:/^\+7\d{10}$/'
        ]);
         $validated = $request->validated();
        // Создание пользователя
        $user = User::create([
            'name' => $validated['name'],
            'login' => $validated['login'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        // Редирект на страницу входа с сообщением
        return redirect('flats')->with('success', 'Регистрация прошла успешно');
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
    if (Auth::attempt($credentials)){
        // Обновляем сессию
        $request -> session() ->regenerate();
        // Проверяем роль пользователя
        if(Auth::user()->role ==='admin'){
            return redirect()-> route('admin.show');
        }
        return redirect('/')-> with('success', 'Успешный вход');
    }
    return back()-> withErrors([
            'login'=>'неверные учетные данные'
        ]);
    }
    // Выход
    public function logout(Request $request)
    {
        // Завершаем сессию пользователя
        Auth::logout();
        // Уничтожаем текущую сессию
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Вы успешно вышли из системы');
    }
}
