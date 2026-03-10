@extends('layouts.admin')  {{-- Теперь подключаем новый layout --}}

@section('title', 'Панель управления')

@section('header', 'Дашборд')  {{-- Это подставится в h1 --}}

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Всего квартир</div>
            <div class="stat-number">{{ $flats_count }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Доступно</div>
            <div class="stat-number">{{ $available_flats }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Продано</div>
            <div class="stat-number">{{ $sold_flats }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Пользователей</div>
            <div class="stat-number">{{ $users_count }}</div>
        </div>
    </div>

    {{-- Здесь можно добавить графики или таблицы --}}
@endsection