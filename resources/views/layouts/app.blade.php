<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мой сайт')</title>
    <link rel="stylesheet" href="{{asset("css/app.css")}}">
        <link rel="stylesheet" href="{{asset("css/profile.css")}}">

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
                     <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">Личный кабинет</a>
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
    <div class="container">
        <div class="footer-content">
          <div class="footer-col-wrapper">
                <div class="footer-col">
                <h4>О компании</h4>
                <p>Строительная компания "Estate" — надёжный застройщик с 2010 года. Все объекты сданы в срок.</p>
            </div>
          </div>
            
          <div class="footer-col-wrapper">
                <div class="footer-col">
                <h4>Информация</h4>
                <ul>
                    <li><a href="/about">О ЖК</a></li>
                    <li><a href="/flats">Квартиры</a></li>
                    <li><a href="/contacts">Контакты</a></li>
                </ul>
            </div>
          </div>
            
          <div class="footer-col-wrapper">
                <div class="footer-col">
                <h4>Контакты</h4>
                <ul>
                    <li>Казань, ул. Центральная, 1</li>
                    <li>+7 (843) 123-45-67</li>
                    <li>info@complex.ru</li>
                </ul>
            </div>
          </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2024 Жилой комплекс "Estate". Все права защищены.</p>
        </div>
    </div>
</footer>

    
</body>
</html>