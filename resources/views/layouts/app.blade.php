<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <link rel="stylesheet" href="{{asset("css/app.css")}}">
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
                <li><a href="#">О нас</a></li>
                <li><a href="#">Ход строительства</a></li>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.index') }}">Админ</a></li>
                    @endif
                    
                    <li><a href="#">Избранные</a></li>
                    <li><a href="#">Мои заявки</a></li>
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