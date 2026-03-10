<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Боковое меню (оно будет на всех страницах админки) -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Админ-панель</h2>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    📊 Дашборд
                </a>
                <a href="" class="{{ request()->routeIs('admin.flats.*') ? 'active' : '' }}">
                    🏢 Квартиры
                </a>
                <a href="" class="{{ request()->routeIs('admin.flats.create') ? 'active' : '' }}">
                    ➕ Добавить квартиру
                </a>
                <a href="" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    👥 Пользователи
                </a>
                
                <div class="sidebar-divider"></div>
                

            </nav>
        </div>

        <!-- Основной контент -->
        <div class="admin-main">
            <div class="admin-header">
                <h1>@yield('header', 'Панель управления')</h1>
                
                {{-- Можно добавить хлебные крошки или профиль админа --}}
                <div class="admin-user">
                    {{ Auth::user()->name }}
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Выйти</button>
                    </form>
                </div>
            </div>
            
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>