@extends('layouts.app')

@section('title', 'регистрация')

@section('content')
<div class="auth-card">
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Введите ваше имя">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Введите ваш email">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Логин:</label>
            <input type="text" name="login" value="{{ old('login') }}" required placeholder="Введите ваш логин">
            @error('login')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Пароль:</label>
            <input type="password" name="password" required placeholder="Введите ваш пароль">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Подтверждение пароля:</label>
            <input type="password" name="password_confirmation" required placeholder="Повторите пароль">
        </div>
        
        <button type="submit" class="btn-primary">Зарегистрироваться</button>
        
        <div class="auth-footer">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
        </div>
    </form>
</div>

<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        color: #2D3436;
        line-height: 1.5;
        background-color: var(--bg-light);
        margin: 0 auto;
        overflow-x: hidden;
    }
    
    /* Стили для карточки с формой */
    .auth-card {
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        animation: fadeInUp 0.5s ease;
        position: relative;
        z-index: 1;
    }

    /* Заголовок формы */
    .auth-card h1 {
        text-align: center;
        margin: 0 0 30px 0;
        color: #333;
        font-size: 32px;
        font-weight: 600;
        font-family: inherit;
    }

    /* Стили для полей формы */
    .auth-card .form-group {
        margin-bottom: 20px;
    }

    .auth-card .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: inherit;
    }

    .auth-card .form-group input {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        box-sizing: border-box;
        background: #f8f9fa;
        line-height: 1.5;
    }

    .auth-card .form-group input:focus {
        outline: none;
        border-color: #1A3B2E;
        background: white;
        box-shadow: 0 0 0 3px rgba(26, 59, 46, 0.1);
    }

    /* Стили для ошибок */
    .auth-card .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 8px;
        background: #fff5f5;
        padding: 8px 12px;
        border-radius: 8px;
        border-left: 3px solid #dc3545;
        font-family: inherit;
    }

    /* Стили для кнопки */
    .auth-card .btn-primary {
        width: 100%;
        padding: 10px;
        background: #1A3B2E;
        color: white;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 400;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.5;
        text-align: center;
        display: inline-block;
    }

    .auth-card .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(26, 59, 46, 0.4);
        background: #0f2b21;
        color: white;
    }

    .auth-card .btn-primary:active {
        transform: translateY(0);
    }

    /* Стили для ссылки регистрации */
    .auth-card .auth-footer {
        text-align: center;
        margin-top: 25px;
        color: #666;
        font-size: 14px;
        font-family: inherit;
    }

    .auth-card .auth-footer a {
        color: #1A3B2E;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
        margin-left: 5px;
        background: none;
        padding: 0;
    }

    .auth-card .auth-footer a:hover {
        color: #0f2b21;
        text-decoration: underline;
        background: none;
    }

    /* Анимация появления */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Адаптивность для мобильных устройств */
    @media (max-width: 480px) {
        .auth-card {
            padding: 30px 20px;
            margin: 15px auto;
        }
        
        .auth-card h1 {
            font-size: 28px;
            margin-bottom: 25px;
        }
        
        .auth-card .form-group input,
        .auth-card .btn-primary {
            padding: 12px;
        }
    }
        .footer{
    display: none;

    }
</style>
@endsection