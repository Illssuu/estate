@extends('layouts.app')

@section('title', $flat->title . ' - Квартира в продаже')
@section('content')
<div class="flat-detail-page">
    <!-- Хлебные крошки -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('flats.index') }}">Квартиры</a></li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <!-- Основная информация -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Заголовок и статус -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="h3 mb-0">{{ $flat->title }}</h1>
                            <div>
                                <span class="badge bg-{{ $flat->status_color }} fs-6">
                                    {{ $flat->status_text }}
                                </span>
                            </div>
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
                                                 style="height: 450px; object-fit: cover;">
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
                                <h3 class="text-primary mb-0">{{ number_format($flat->price, 0, ',', ' ') }} ₽</h3>
                            </div>
                            <a href="#" class="favorite-link">
                                <img src="{{ asset('img/favorites-icon1.svg') }}" 
                                     alt="В избранное">
                            </a>
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
                        @php
                            $similarFlats = \App\Models\Flat::where('id', '!=', $flat->id)
                                ->where('rooms', $flat->rooms)
                                ->where('is_available', true)
                                ->limit(3)
                                ->get();
                        @endphp
                        
                        @if($similarFlats->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($similarFlats as $similar)
                                    <a href="{{ route('flats.show', $similar->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $similar->title }}</h6>
                                            <small>{{ $similar->formatted_price }}</small>
                                        </div>
                                        <small class="text-muted">
                                            {{ $similar->area }} м², {{ $similar->floor }}/{{ $similar->total_floors }} эт.
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small">Нет похожих квартир</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Модальное окно для заказа звонка -->
<div class="modal fade" id="callRequestModal" tabindex="-1" aria-labelledby="callRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="callRequestModalLabel">
                    <i class="bi bi-telephone-inbound me-2"></i>
                    Заказать звонок
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <!-- Форма заказа звонка -->
                <form id="callRequestForm">
                    @csrf
                    <input type="hidden" name="flat_id" value="{{ $flat->id }}">
                    
                    <!-- Поле имени -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Ваше имя <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               placeholder="Введите ваше имя" required>
                    </div>
                    
                    <!-- Поле телефона -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="+7 (___) ___-__-__" required>
                    </div>
                    
                    <!-- Кнопка отправки -->
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-telephone me-2"></i>
                        Заказать звонок
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Минимальные стили для модального окна */
#callRequestModal .modal-content {
    border-radius: 12px;
    border: none;
}

#callRequestModal .modal-header {
    background: #0051ffff;
    color: white;
    border-radius: 12px 12px 0 0;
}

#callRequestModal .modal-header .btn-close {
    filter: brightness(0) invert(1);
}

#callRequestModal .btn-primary {
    border: none;
}

#callRequestModal .btn-primary:hover {

}

#callRequestModal .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(123, 81, 65, 0.25);
}
</style>

<script>
// Маска для телефона
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 1) {
                    value = value.replace(/^(\d)/, '+7 ($1');
                } else if (value.length <= 4) {
                    value = value.replace(/^(\d{1})(\d{0,3})/, '+7 ($1) $2');
                } else if (value.length <= 7) {
                    value = value.replace(/^(\d{1})(\d{3})(\d{0,3})/, '+7 ($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{1})(\d{3})(\d{3})(\d{0,2})/, '+7 ($1) $2-$3-$4');
                }
                e.target.value = value;
            }
        });
    }
});

// Функция для открытия модального окна
function openCallRequestModal() {
    const modal = new bootstrap.Modal(document.getElementById('callRequestModal'));
    modal.show();
}
</script>
</div>
@endsection

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
</script>