@extends('layouts.app')

@section('title', "Настройки профиля")
@section('content')

<div class="settings-page">
    <div class="settings-layout">
        <!-- Основной контент -->
        <div class="settings-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Личные данные -->
            <div id="profile-info" class="settings-card">
                <div class="card-header">
                    <h3>Личные данные</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf 

                        <div class="form-group">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Электронная почта</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Телефон</label>
                            <input type="tel" name="phone" class="form-control"  
                                   value="{{ old('phone', auth()->user()->phone) }}" 
                                   placeholder="+7 (999) 123-45-67">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button> 
                    </form>
                </div>
            </div>

            <!-- Смена пароля -->
            <div id="change-password" class="settings-card">
                <div class="card-header">
                    <h3>Смена пароля</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf 

                        <div class="form-group">
                            <label for="current-password" class="form-label">Текущий пароль</label>
                            <input type="password" id="current-password" name="current_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="new-password" class="form-label">Новый пароль</label>
                            <input type="password" id="new-password" name="new_password" class="form-control" required>
                        </div>
            
                        <div class="form-group">
                            <label for="new-password-confirmation" class="form-label">Подтверждение пароля</label>
                            <input type="password" id="new-password-confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Изменить пароль</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-page {
    padding: 40px 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.settings-layout {
    margin: 0 auto;
    padding: 0 15px;
}

/* Боковая панель */
.settings-sidebar {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 25px;
    height: fit-content;
    position: sticky;
    top: 20px;
}

.settings-sidebar h4 {
    margin: 0 0 5px;
    font-size: 18px;
    color: #333;
}

.user-email {
    margin: 0 0 20px;
    font-size: 14px;
    color: #999;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.settings-menu {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.settings-menu-item {
    padding: 10px 15px;
    color: #555;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s;
}

.settings-menu-item:hover {
    background: #f5f5f5;
}

.settings-menu-item.active {
    background: #2c3e50;
    color: white;
}

/* Основной контент */
.settings-content {
    min-width: 0;
}

.settings-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    overflow: hidden;
}

.card-header {
    padding: 20px 25px;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.card-header h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.card-body {
    padding: 25px;
}

/* Формы */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #2c3e50;
    box-shadow: 0 0 0 3px rgba(44,62,80,0.1);
}

/* Кнопки */
.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary {
    background: #2c3e50;
    color: white;
}

.btn-primary:hover {
    background: #1e2b37;
}

/* Алерты */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    position: relative;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-close {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: inherit;
    opacity: 0.5;
}

.alert-close:hover {
    opacity: 1;
}

.error-list {
    margin: 0;
    padding-left: 20px;
}

/* Адаптивность */
@media (max-width: 768px) {
    .settings-layout {
        grid-template-columns: 1fr;
    }
    
    .settings-sidebar {
        position: static;
    }
}
</style>
@endsection