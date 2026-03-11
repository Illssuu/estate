@extends('layouts.app')

@section('title', 'Жилой комплекс "ESTATE" - квартиры в Казани')
@section('content')

<section class="hero">
<div class="container">
    <div class="hero-text">
        <h1>Жилой комплекс "ESTATE"</h1>
        <p>Современные квартиры в экологическом районе Казани</p>
        <a href="#" class="btn primary-btn">Выбрать квартиру</a>
    </div>
</div>
</section>


{{-- о комплексе --}}
<section class="about">
    <div class="container">
        <div class="section-header">
        <h2>О жилом комплексе</h2>
        <p>Комфорт и качество жизни в каждой детали</p>
        </div>
        
        <div class="about-grid">
            <div class="about-img">
                <img src="/imf" alt="жилой комплекс">
            </div>
        
            <div class="about-content">
                <h3>Современный квартал для всей семьи</h3>
                <p>Жилой комплекс «ESTATE» расположен в одном из самых живописных районов Москвы. Это не просто дом, а целый квартал с собственной инфраструктурой: детский сад, школа, фитнес-центр и зоны отдыха.</p>
            </div>
            
            <ul class="about-stats">
                <li class="stat-item">
                    <span class="stat-number">25</span>
                    <span class="stat-label">этажей</span>
                </li>
                <li class="stat-item">
                    <span class="stat-number">450</span>
                    <span class="stat-label">квартир</span>
                </li>
                <li class="stat-item">
                    <span class="stat-number">2025</span>
                    <span class="stat-label">год сдачи</span>
                </li>
                <li class="stat-item">
                    <span class="stat-number">2</span>
                    <span class="stat-label">минуты до метро</span>
                </li>
            </ul>
        </div>
    </div>
</section>


{{-- преимущества --}}
<section class="advantages">
    <div class="container">
        <div class="section-header">
            <h2>Наши преимущества</h2>
            <p>Почему люди выбирают именно нас</p>
        </div>
        
        <ul class="advantages-cards">
            <li class="advantage-card">
                <h3>Качественная отделка</h3>
                <p>Квартиры с отделкой от застройщика или под чистовую отделку — выбирайте сами</p>
            </li>
            <li class="advantage-card">
                <h3>Панорамные виды</h3>
                <p>Живописные виды на парк и город с верхних этажей</p>
            </li>
            <li class="advantage-card">
                <h3>Рядом с метро</h3>
                <p>7 минут пешком до станции метро </p>
            </li>
            <li class="advantage-card">
                <h3>Инфраструктура</h3>
                <p>Магазины, аптеки, кафе на первых этажах</p>
            </li>
        </ul>
    </div>
</section>


{{-- каталог квартир --}}
<section class="catalog" id="catalog">
<div class="container">
    <div class="section-header">
        <h2>Квартиры в продаже</h2>
        <p>{{$flats->total()}} квартир доступно для бронирования</p>
    </div>

    {{-- фильтр --}}
    <div class="filter-setion">
        <form action="{{ route('flats.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-item">
                    <label for="rooms">Количество комнат</label>
                    <select name="rooms" id="roooms">
                     <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1 комната</option>
                     <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2 комнаты</option>
                     <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3 комнаты</option>
                     <option value="4" {{ request('rooms') == '4' ? 'selected' : '' }}>4+ комнаты</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="max-price">Цена до, ₽</label>
                    <input type="number" name="max-price" value="{{ request('max_price')}}">
                </div>
                <div class="filter-item">
                    <label for="min_area">Площадь от, м²</label>
                    <input type="number" name="min-area" value="{{ request('min_area') }}">
                </div>
                <div class="filter-item">
                    <button type="submit" class="btn form-btn">Показать</button>
                    <a href="{{ route('flats.index') }}" class="btn btn-outline filter-reset">Сбросить</a>
                </div>
            </div>
        </form>
    </div>

    {{-- список квартир --}}
                @if($flats->count() > 0)
                <div class="flats-grid">
                    @foreach($flats as $flat)
                    <div class="flat-card">
                        <div class="flat-card-header">
                            <div class="flat-badges">
                                <span class="badge badge-{{ $flat->housing_type }}">
                                    {{ $flat->housing_type == 'new_building' ? 'Новостройка' : 'Вторичка' }}
                                </span>
                                <span class="badge badge-rooms">{{ $flat->rooms }}-комнатная</span>
                            </div>
                            @if($flat->balcony)
                                <span class="badge-feature">Балкон</span>
                            @endif
                            @auth
                            <button class="favorite-btn {{ auth()->user()->favorites->contains($flat->id) ? 'active' : '' }}" onclick="toggleFavorite({{ $flat->id }})"  data-flat-id="{{ $flat->id }}">
                                 <span class="heart">❤</span>
                            </button>
                            @else 
                            <a href="{{ route('login.show') }}" class="favorite-btn login-required" title="Войдите, чтобы добавить в избранное">
                                <span class="heart">❤</span>
                            </a>
                            @endauth
                        </div>
                        
                        <div class="flat-card-body">
                            <h3 class="flat-title">{{ $flat->title }}</h3>
                            
                            <div class="flat-price">
                                <span class="price-value">{{ number_format($flat->price, 0, '.', ' ') }} ₽</span>
                                <span class="price-meter">{{ number_format($flat->price / $flat->area, 0, '.', ' ') }} ₽/м²</span>
                            </div>
                            
                            <div class="flat-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Площадь</span>
                                    <span class="spec-value">{{ $flat->area }} м²</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Этаж</span>
                                    <span class="spec-value">{{ $flat->floor }}/{{ $flat->total_floors }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Отделка</span>
                                    <span class="spec-value">
                                        @if($flat->finishing == 'rough')
                                            Черновая
                                        @elseif($flat->finishing == 'fine')
                                            Чистовая
                                        @else
                                            Дизайнерская
                                        @endif
                                    </span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Санузел</span>
                                    <span class="spec-value">
                                        {{ $flat->bathroom == 'separate' ? 'Раздельный' : 'Совмещенный' }}
                                    </span>
                                </div>
                            </div>
                            
                            <p class="flat-description">{{ Str::limit($flat->description, 100) }}</p>
                        </div>
                        
                        <div class="flat-card-footer">
                            <a href="{{ route('flats.show', $flat->id) }}" class="btn btn-outline btn-block">Подробнее</a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $flats->withQueryString()->links() }}
                </div>
                @else
                <div class="no-results">
                    <h3>Квартиры не найдены</h3>
                    <p>Попробуйте изменить результаты поиска</p>
                </div>
               @endif
</div>
</section>

{{-- контакты --}}
<section class="contacts">
    <div class="container">
                  <div class="contacts-grid">
                <div class="contacts-info">
                    <h2 class="section-title">Контакты</h2>
                    <p class="contacts-text">Приходите в наш офис продаж или свяжитесь с нами любым удобным способом</p>
                    
                    <div class="contacts-list">
                        <div class="contact-item">
                            <div>
                                <h4>Адрес офиса продаж</h4>
                                <p>г. Казань, ул. Строителей, д. 1</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div>
                                <h4>Телефон</h4>
                                <p><a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div>
                                <h4>Email</h4>
                                <p><a href="mailto:sales@complex.ru">sales@complex.ru</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div>
                                <h4>Режим работы</h4>
                                <p>Пн-Пт: 9:00-20:00, Сб-Вс: 10:00-18:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contacts-map">
                    <!-- Здесь будет карта (Яндекс/Google) -->
                    <div class="map-placeholder">
                        <iframe src="https://yandex.ru/map-widget/v1/?ll=37.617698,55.755864&z=12" width="100%" height="100%" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
    </div>
</section>

{{-- тут будет блок с заявкой --}}
<script>
function toggleFavorite(flatId) {
    @auth
    fetch(`/profile/favorites/toggle/${flatId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.querySelector(`[data-flat-id="${flatId}"]`);
            if (data.added) {
                btn.classList.add('active');
                // Можно показать уведомление
                showNotification('Добавлено в избранное');
            } else {
                btn.classList.remove('active');
                showNotification('Удалено из избранного');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    @endauth
}

// Простое уведомление (опционально)
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #2c3e50;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 2000);
}
</script>
@endsection