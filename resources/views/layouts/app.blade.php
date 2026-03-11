<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мой сайт')</title>
    <link rel="stylesheet" href="{{asset("css/app.css")}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <!-- Header -->
<nav class="main-nav">
    <div class="nav-container">
        <ul class="nav-menu">
            <!-- Левые пункты меню -->
            <div class="nav-left">
                <li><a href="{{ route('flats.index') }}">Главная</a></li>
                <li><a href="#">Условия</a></li>
                <li><a href="{{ route('about') }}">О нас</a></li>
                <li><a href="#">Ход строительства</a></li>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.index') }}">Админ</a></li>
                    @endif
                     <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">Личный кабинет</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.favorites') }}">Личный кабинет</a>
                        </li>
                @endauth
            </div>
            
            <!-- Правые пункты (вход/регистрация/профиль) -->
            <div class="nav-right">
                @auth
                    <li><span>Привет, {{ Auth::user()->name }}!</span></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Выйти</button>
                        </form>
                    </li>
                    
                @else
                    <li><a href="{{ route('login.show') }}">Войти</a></li>
                    <li><a href="{{ route('register.show') }}">Регистрация</a></li>
                @endauth
            </div>
        </ul>
    </div>
</nav>
    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} MyShop. Все права защищены.</p>
        </div>
    </footer>

    
</body>
</html>