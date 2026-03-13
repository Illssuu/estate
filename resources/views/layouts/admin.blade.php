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
    <div class="admin-wrapper" style="display: flex;">
                <!-- Боковое меню (оно будет на всех страницах админки) -->
        <div class="admin-sidebar" style="width: 250px; flex-shrink: 0;">
            <div class="sidebar-header">
                <h2>Админ-панель</h2>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('flats.index') }}">Главная</a>

                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                     Дашборд
                </a>
                <a href="{{ route(('admin.flats.index')) }}" class="{{ request()->routeIs('admin.flats.*') ? 'active' : '' }}">
                     Квартиры
                </a>
                <a href="{{ route('admin.flats.create') }}" class="{{ request()->routeIs('admin.flats.create') ? 'active' : '' }}">
                     Добавить квартиру
                </a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                     Пользователи
                </a>
 <a href="{{ route('admin.applications') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                     зай
                </a>
                
                <div class="sidebar-divider"></div>
                

            </nav>
        </div>

        <!-- Основной контент -->
        <div class="admin-main" style="flex: 1; padding: 20px;">
            <div class="admin-header">
                <h1>@yield('header', 'Панель управления')</h1>
                
                {{-- Можно добавить хлебные крошки или профиль админа --}}
                <div class="admin-user">
                 
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <img src="{{ asset('img/Log out.svg') }}" alt="Выйти" width="20" height="20">


        
                        </button>
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