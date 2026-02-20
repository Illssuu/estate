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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('flats.index') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Условия</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ход строительства</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.show') }}">Войти</a>
                    </li>
                @auth
                 <!-- Для авторизованных пользователей -->
                    @if(Auth::user()->isAdmin())
                        <!-- <li class="nav-item nav-item_4">
                            <a href="">Добавить квартиру</a>
                        </li>
                        <li class="nav-item nav-item_4">
                            <a href="">Заявки</a>
                        </li> -->
                        <li class="nav-item nav-item_4">
                            <a href="">Админ</a>
                        </li>
                    @endif
                        <li class="nav-item">
                            <span>Привет, {{ Auth::user()->name }}!</span>
                        </li>
                        <li class="nav-item nav-item_4">
                                <a href="">Избранные</a>
                        </li>
                        <li class="nav-item nav-item_4">
                                <a href="">Мои заявки</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="" class="inline">
                                @csrf
                                <button type="submit">Выйти</button>
                            </form>
                        </li>
                    
                @endauth
                </ul>
            </div>
        </div>
        
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
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