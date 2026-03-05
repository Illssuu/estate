@extends('layouts.app')
@section('content')
<h1>Регистрация</h1>
<form method="POST" action="{{ route('register') }}">
@csrf

<div>
    <label>Логин:</label>
    <input type="text" name="login" value="{{ old('login') }}" required>
    @error('login')
    <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label>Пароль:</label>
    <input type="password" name="password" required>
    @error('password')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="password_confirmation">Повтор пароля:</label>
    <input type="password" name="password_confirmation" required>
</div>

<div>
    <label>Имя:</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    @error('name')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label>Телефон(+7XXXXXXXXXX):</label>
    <input name="phone" value="{{ old('phone') }}" required>
    @error('phone')
        <div>{{ $message }}</div>
    @enderror
</div>
<div>
    <label>Почта:</label>
    <input name="email" value="{{ old('email') }}" required>
    @error('email')
        <div>{{ $message }}</div>
    @enderror
</div>

<button type="submit">Создать пользователя</button>
<p>Есть аккаунт? <a href="{{ route('login.show') }}">Вход</a></p>
</form>
@endsection
