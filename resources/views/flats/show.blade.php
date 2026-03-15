@extends('layouts.app')

@section('title', $flat->title . ' - Квартира в продаже')
@section('content')
<div class="flat-detail-page">
    <div class="container_show" style=" max-width: 1200px;  margin: 0 auto;">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('flats.index') }}">Квартиры</a></li>
            </ol>
        </nav>
        <div class="row">
            <!-- Основная информация -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Заголовок и статус -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="h3 mb-0">{{ $flat->title }}</h1>

                        </div>
                        

                        <!-- ГАЛЕРЕЯ КАРТИНОК -->
                        @php
                            $images = $flat->photos;
                        @endphp

                        @if($images->count() > 0)
                        <div class="card mb-4">
                            <div class="card-body p-0">
                                <div id="flatGallery" class="carousel slide" data-bs-ride="carousel">
                                    <!-- Индикаторы (точки) -->
                                    @if($images->count() > 1)
                                    <div class="carousel-indicators">
                                        @foreach($images as $key => $image)
                                        <button type="button" 
                                                data-bs-target="#flatGallery" 
                                                data-bs-slide-to="{{ $key }}" 
                                                class="{{ $key == 0 ? 'active' : '' }}"
                                                aria-label="Слайд {{ $key + 1 }}"></button>
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    <!-- Слайды -->
                                    <div class="carousel-inner">
                                        @foreach($images as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ $image->url }}" 
                                                 class="d-block w-100" 
                                                 alt="{{ $image->image_name ?: $flat->title }}"
                                                 style="height: 450px; object-fit: cover; cursor: pointer;"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#imageModal"
                                                 onclick="showFullImage('{{ $image->url }}')">
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Стрелки навигации -->
                                    @if($images->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#flatGallery" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Предыдущая</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#flatGallery" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Следующая</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Заглушка, если нет фото -->
                        <div class="card mb-4">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                                <p class="text-muted mt-3">Нет фотографий</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Основные параметры в список -->
                        <div class="parameters-list mb-4">
                            <div class="row">
                                <h4>О квартире</h4>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Общая площадь:</span>
                                            <strong>{{ $flat->area }} м²</strong>
                                        </li>
                                        @if($flat->living_area)
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Жилая площадь:</span>
                                            <strong>{{ $flat->living_area }} м²</strong>
                                        </li>
                                        @endif
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Комнат:</span>
                                            <strong>{{ $flat->rooms }}</strong>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Этаж:</span>
                                            <strong>{{ $flat->floor }} / {{ $flat->total_floors }}</strong>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Тип жилья:</span>
                                            <strong>{{ $flat->housing_type_text }}</strong>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Отделка:</span>
                                            <strong>{{ $flat->finishing_text }}</strong>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Вид из окна:</span>
                                            <strong>{{ $flat->view_type_text }}</strong>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Санузел:</span>
                                            <strong>{{ $flat->bathroom_text }}</strong>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <span class="text-muted me-2" style="min-width: 120px;">Балкон:</span>
                                            <strong>{{ $flat->balcony ? 'Есть' : 'Нет' }}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Описание -->
                        @if($flat->description)
                        @php
                            $descLength = strlen($flat->description);
                            $needTruncate = $descLength > 100;
                        @endphp

                        <div class="description mt-4" id="descriptionContainer">
                            <h6 class="mb-3">Описание</h6>
                            
                            @if($needTruncate)
                                <!-- С обрезанием -->
                                <div class="description-content collapsed" id="descriptionContent">
                                    <p class="text-justify description-text" id="descriptionText">
                                        {{ $flat->description }}
                                    </p>
                                </div>
                                
                                <!-- Ссылки -->
                                <div class="description-actions mt-3" id="descriptionActions">
                                    <a href="javascript:void(0);" class="description-link" id="showMoreLink" onclick="toggleDescription(); return false;">
                                        Узнать больше <i class="bi bi-arrow-down ms-1"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="description-link d-none" id="showLessLink" onclick="toggleDescription(); return false;">
                                        Скрыть <i class="bi bi-arrow-up ms-1"></i>
                                    </a>
                                </div>
                            @else
                                <!-- Без обрезания -->
                                <div class="description-content expanded">
                                    <p class="text-justify description-text">
                                        {{ $flat->description }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            
            <!-- Боковая панель -->
            <div class="col-lg-4">
                <!-- Карточка с ценой -->
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Цена и избранное -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class=" text-primary mb-0" >{{ number_format($flat->price, 0, ',', ' ') }} ₽</h3>
                            </div>
                           <!-- избранное -->
@auth
    <a href="#" class="favorite-link {{ auth()->user()->favorites->contains($flat->id) ? 'active' : '' }}" 
       onclick="toggleFavorite({{ $flat->id }}); return false;" 
       data-flat-id="{{ $flat->id }}">
        <img src="{{ asset('img/favorites-icon1.svg') }}" 
             alt="В избранное">
    </a>
@else 
    <a href="{{ route('login') }}" class="favorite-link">
        <img src="{{ asset('img/favorites-icon1.svg') }}" 
             alt="В избранное">
    </a>
@endauth
                        </div>
                        
                        <div class="text-muted small mb-3">
                            {{ number_format($flat->price / $flat->area, 0, ',', ' ') }} ₽/м²
                        </div>
                        
                        <!-- ГРАФИК ЦЕН С КНОПКОЙ -->
                        @if($flat->priceHistory && $flat->priceHistory->count() > 0)
                        <div class="price-history-section mt-3">
                            <!-- Кнопка для открытия графика (в стиле "Заказать звонок") -->
                            <a href="javascript:void(0);" class="btn btn-primary w-100 d-flex align-items-center justify-content-between" onclick="togglePriceHistory(); return false;">
                                <span><i class="bi bi-graph-up me-2"></i>Показать историю цен</span>
                                <i class="bi bi-chevron-down toggle-icon"></i>
                            </a>
                            
                            <!-- Контейнер с графиком (изначально скрыт) -->
                            <div class="price-chart-container mt-3" id="priceHistoryContainer" style="display: none;">
                                <div id="price_chart_{{ $flat->id }}" style="width: 100%; height: 200px;"></div>
                                
                                @php
                                    $firstPrice = $flat->priceHistory->first()->price ?? $flat->price;
                                    $lastPrice = $flat->price;
                                    $diff = $lastPrice - $firstPrice;
                                    $percent = $firstPrice > 0 ? round(($diff / $firstPrice) * 100, 1) : 0;
                                @endphp
                            </div>
                        </div>
                        @else
                        <div class="alert alert-secondary small py-2 mb-3">
                            <i class="bi bi-graph-up me-2"></i>
                            Нет данных об изменении цены
                        </div>
                        @endif
                        
                        <hr class="mt-4">
                        
                        <!-- Кнопка заказа звонка -->
                       <!-- Замените существующую кнопку на эту: -->
@if($flat->is_available && $flat->status == 'available')
    <div class="d-grid gap-2 mb-3">
        <a href="#" class="btn btn-primary w-100" onclick="openCallRequestModal(); return false;">
            <i class="bi bi-telephone me-2"></i>Заказать звонок
        </a>
    </div>
@elseif($flat->status == 'reserved')
    <div class="alert alert-warning">
        <h5><i class="bi bi-clock-history me-2"></i>Квартира забронирована</h5>
        <p class="mb-0">Эта квартира временно недоступна для покупки.</p>
    </div>
@else
    <div class="alert alert-secondary">
        <h5><i class="bi bi-check-circle me-2"></i>Квартира продана</h5>
        <p class="mb-0">Эта квартира уже продана.</p>
    </div>
@endif
                        <hr>
                        
                        <!-- Контактная информация -->
                        <div class="contact-info">
                            <h6 class="mb-3">Контакты отдела продаж:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-telephone me-2 text-primary"></i>
                                    <strong>+7 (495) 123-45-67</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-envelope me-2 text-primary"></i>
                                    sales@example.com
                                </li>
                                <li>
                                    <i class="bi bi-clock me-2 text-primary"></i>
                                    Пн-Пт: 9:00-20:00
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Похожие квартиры -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Похожие квартиры</h5>
                        @if($similarFlats->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($similarFlats as $similar)
                                    <a href="{{ route('flats.show', $similar->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $similar->title }}</h6>
                                            <small style="white-space: nowrap;">{{ number_format($similar->price, 0, ',', ' ') }} ₽</small>
                                        </div>
                                        <small class="text-muted">
                                            {{ $similar->area }} м², {{ $similar->floor }}/{{ $similar->total_floors }} эт.
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">Нет похожих квартир</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ПРОСТОЕ МОДАЛЬНОЕ ОКНО на весь экран -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img id="fullscreenImage" src="" class="img-fluid" style="max-height: 90vh;">
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для заказа звонка (стиль как на странице "Мои заявки") -->
    <div id="callRequestModal" class="modal" style="display: none;">
        <div class="modal-content" style="max-width: 500px; margin: auto; background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
            <div class="modal-header" style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 class="modal-title" style="margin: 0; font-size: 18px; color: #333; font-weight: 500;">Новая заявка на звонок</h3>
                <button type="button" class="modal-close" onclick="closeCallRequestModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999; padding: 0; line-height: 1;">×</button>
            </div>
            
            <form action="{{ route('applications.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 20px;">
                    <input type="hidden" name="flat_id" value="{{ $flat->id }}">
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" style="display: block; margin-bottom: 5px; font-size: 14px; color: #555;">Ваше имя</label>
                        <input type="text" name="name" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" style="display: block; margin-bottom: 5px; font-size: 14px; color: #555;">Номер телефона</label>
                        <input type="tel" name="phone" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="+7 (___) ___-__-__" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label class="form-label" style="display: block; margin-bottom: 5px; font-size: 14px; color: #555;">Комментарий (необязательно)</label>
                        <textarea name="comment" class="form-control" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; resize: vertical;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 20px; border-top: 1px solid #eee; display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="closeCallRequestModal()" style="padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; background: #e0e0e0; color: #333;">Отмена</button>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; background: #2c3e50; color: white;">Отправить заявку</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- СТИЛИ CSS -->
<style>
/* Основные стили для параметров */
.parameters-list li {
    padding: 6px 0;
    border-bottom: 1px solid #f0f0f0;
}
.parameters-list li:last-child {
    border-bottom: none;
}

/* Скрываем навигацию (если нужно) */
.main-nav {
    display: none;
}

/* Стили для описания */
.description-content {
    position: relative;
    overflow: hidden;
    transition: max-height 0.3s ease;
}
.description-content.collapsed {
    max-height: 100px;
}
.description-content.expanded {
    max-height: 1000px;
}
.description-text {
    margin-bottom: 0;
}
.description-actions {
    text-align: left;
}
.description-link {
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}
.description-link:hover {
    text-decoration: underline;
}
.description-link i {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}
.description-link:hover i {
    transform: translateY(2px);
}
#showLessLink:hover i {
    transform: translateY(-2px);
}

/* Стили для графика */
.price-chart-container {
    background: #ffffff;
    border-radius: 10px;
    padding: 15px 10px 10px 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.price-stats {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 3px solid #7b5141;
}
.price-stats .d-flex {
    padding: 4px 0;
}
.text-success { color: #28a745 !important; }
.text-danger { color: #dc3545 !important; }

/* Стили для избранного */
.favorite-link {
    display: inline-block;
    width: 20px;
    height: 20px;
}
.favorite-link img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Анимация для иконки */
.toggle-icon {
    transition: transform 0.3s ease;
}

.favorite-link.active img {
    filter: brightness(0) saturate(100%) invert(27%) sepia(94%) saturate(3746%) hue-rotate(355deg) brightness(94%) contrast(92%);
}

/* Стили для модального окна */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 500px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 18px;
    color: #333;
    font-weight: 500;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
    padding: 0;
    line-height: 1;
}

.modal-close:hover {
    color: #333;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
}



.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-primary {
    background: #1a3b2e;
    color: white;
}

.btn-primary:hover {
    background: #122f23ff;
}

.btn-secondary {
    background: #e0e0e0;
    color: #333;
}

.btn-secondary:hover {
    background: #d0d0d0;
}

@media (max-width: 600px) {
    .modal-footer {
        flex-direction: column;
    }
    
    .modal-footer .btn {
        width: 100%;
    }
}
btn-primary.active,
.btn-primary:focus:active,
.price-history-section .btn:active,
.d-grid .btn:active,
button.btn-primary:active {
    background: #0f2b21; /* темно-зеленый при нажатии */

}

</style>

<!-- ПОДКЛЮЧЕНИЕ БИБЛИОТЕК -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- СКРИПТЫ JS -->
<script>
// Функция для сворачивания/разворачивания описания
function toggleDescription() {
    const content = document.getElementById('descriptionContent');
    const showMoreLink = document.getElementById('showMoreLink');
    const showLessLink = document.getElementById('showLessLink');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        showMoreLink.classList.add('d-none');
        showLessLink.classList.remove('d-none');
    } else {
        content.classList.remove('expanded');
        content.classList.add('collapsed');
        showMoreLink.classList.remove('d-none');
        showLessLink.classList.add('d-none');
    }
}

// Функция для графика цен
google.charts.load('current', { packages: ['corechart', 'line'] });

function drawPriceChart() {
    const data = new google.visualization.DataTable();
    data.addColumn('string', 'Дата');
    data.addColumn('number', 'Цена');
    
    data.addRows([
        @foreach($flat->priceHistory as $history)
        ['{{ $history->date->format('d.m') }}', {{ $history->price }}],
        @endforeach
    ]);
    
    const options = {
        curveType: 'function',
        legend: { position: 'none' },
        backgroundColor: 'transparent',
        chartArea: {
            left: 50,
            top: 20,
            right: 20,
            bottom: 30,
            width: '100%',
            height: '80%'
        },
        colors: ['#7b5141'],
        pointSize: 6,
        pointShape: 'circle',
        lineWidth: 2,
        hAxis: { textStyle: { fontSize: 10 } },
        vAxis: {
            format: 'short',
            gridlines: { count: 5 },
            textStyle: { fontSize: 10 }
        },
        tooltip: { trigger: 'focus', textStyle: { fontSize: 12 } }
    };
    
    const chart = new google.visualization.LineChart(
        document.getElementById('price_chart_{{ $flat->id }}')
    );
    
    chart.draw(data, options);
}

function togglePriceHistory() {
    const container = document.getElementById('priceHistoryContainer');
    const toggleBtn = document.querySelector('.price-history-section .btn');
    const toggleIcon = document.querySelector('.price-history-section .toggle-icon');
    
    if (container.style.display === 'none') {
        container.style.display = 'block';
        toggleIcon.classList.remove('bi-chevron-down');
        toggleIcon.classList.add('bi-chevron-up');
        toggleBtn.innerHTML = '<span><i class="bi bi-graph-up me-2"></i>Скрыть историю цен</span><i class="bi bi-chevron-up toggle-icon"></i>';
        
        setTimeout(() => {
            drawPriceChart();
        }, 100);
    } else {
        container.style.display = 'none';
        toggleIcon.classList.remove('bi-chevron-up');
        toggleIcon.classList.add('bi-chevron-down');
        toggleBtn.innerHTML = '<span><i class="bi bi-graph-up me-2"></i>Показать историю цен</span><i class="bi bi-chevron-down toggle-icon"></i>';
    }
    
}

// Функция для открытия модального окна
function openCallRequestModal() {
    document.getElementById('callRequestModal').style.display = 'flex';
}

function closeCallRequestModal() {
    document.getElementById('callRequestModal').style.display = 'none';
}

// Функция для показа картинки на весь экран
function showFullImage(imageUrl) {
    document.getElementById('fullscreenImage').src = imageUrl;
}

// Закрытие модального окна при клике вне его
window.onclick = function(event) {
    const modal = document.getElementById('callRequestModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

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
            // ТОЛЬКО ЭТУ СТРОКУ ИСПРАВИЛ
            const btn = document.querySelector(`.favorite-link[data-flat-id="${flatId}"]`);
            
            if (data.added) {
                btn.classList.add('active');
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