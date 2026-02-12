@extends('layouts.app')

@section('title', 'вход')
@section('content')
<h1>Вход</h1>
<form method="POST" action="{{ route('login') }}">
@csrf

<div>
    <label>Логин:</label>
    <input name="login" value="{{ old('login') }}" required>
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
<button type="submit">Вход</button>
<p>Нет аккаунта? <a href="{{ route('register.show') }}">Зарегистрироваться</a></p>
</form>
@endsection