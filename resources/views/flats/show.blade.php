@extends('layouts.app')

@section('title', $flat->title . ' - Квартира в продаже')
@section('content')
<div class="flat-detail-page">
    <div class="container_show" style="max-width: 1200px; margin: 0 auto;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('flats.index') }}">Квартиры</a></li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="h3 mb-0">{{ $flat->title }}</h1>
                        </div>

                        <!-- ГАЛЕРЕЯ КАРТИНОК -->
                        @php $images = $flat->photos; @endphp

                        @if($images->count() > 0)
                        <div class="card mb-4">
                            <div class="card-body p-0">
                                <div id="flatGallery" class="carousel slide">
                                    <div class="carousel-inner">
                                        @foreach($images as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ $image->url }}" 
                                                class="d-block w-100" 
                                                alt="{{ $image->image_name ?: $flat->title }}"
                                                style="height: 450px; object-fit: cover; cursor: pointer;"
                                                onclick="showFullImage('{{ $image->url }}')">
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($images->count() > 1)
                                    <a class="carousel-control-prev" href="javascript:void(0)" onclick="prevSlide()">
                                        <span class="carousel-control-prev-icon"></span>
                                    </a>
                                    <a class="carousel-control-next" href="javascript:void(0)" onclick="nextSlide()">
                                        <span class="carousel-control-next-icon"></span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card mb-4">
                            <div class="card-body text-center py-5">
                                <div class="no-photo-icon"></div>
                                <p class="text-muted mt-3">Нет фотографий</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="parameters-list mb-4">
                            <div class="row">
                                <h4>О квартире</h4>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Общая площадь:</span><strong>{{ $flat->area }} м²</strong></li>
                                        @if($flat->living_area)<li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Жилая площадь:</span><strong>{{ $flat->living_area }} м²</strong></li>@endif
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Комнат:</span><strong>{{ $flat->rooms }}</strong></li>
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Этаж:</span><strong>{{ $flat->floor }} / {{ $flat->total_floors }}</strong></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Тип жилья:</span><strong>{{ $flat->housing_type_text }}</strong></li>
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Отделка:</span><strong>{{ $flat->finishing_text }}</strong></li>
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Вид из окна:</span><strong>{{ $flat->view_type_text }}</strong></li>
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Санузел:</span><strong>{{ $flat->bathroom_text }}</strong></li>
                                        <li class="mb-2 d-flex"><span class="text-muted me-2" style="min-width: 120px;">Балкон:</span><strong>{{ $flat->balcony ? 'Есть' : 'Нет' }}</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if($flat->description)
                        @php $needTruncate = strlen($flat->description) > 100; @endphp
                        <div class="description mt-4" id="descriptionContainer">
                            <h6 class="mb-3">Описание</h6>
                            @if($needTruncate)
                                <div class="description-content collapsed" id="descriptionContent"><p class="description-text">{{ $flat->description }}</p></div>
                                <div class="description-actions mt-3">
                                    <a href="javascript:void(0);" class="description-link" id="showMoreLink" onclick="toggleDescription()">Узнать больше ↓</a>
                                    <a href="javascript:void(0);" class="description-link d-none" id="showLessLink" onclick="toggleDescription()">Скрыть ↑</a>
                                </div>
                            @else
                                <div class="description-content expanded"><p class="description-text">{{ $flat->description }}</p></div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div><h3 class="price">{{ number_format($flat->price, 0, ',', ' ') }} ₽</h3></div>
                            @auth
                            <a href="#" class="favorite-link {{ auth()->user()->favorites->contains($flat->id) ? 'active' : '' }}" onclick="toggleFavorite({{ $flat->id }}); return false;" data-flat-id="{{ $flat->id }}">
                                <img src="{{ asset('img/favorites-icon1.svg') }}" alt="В избранное">
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="favorite-link"><img src="{{ asset('img/favorites-icon1.svg') }}" alt="В избранное"></a>
                            @endauth
                        </div>
                        <div class="price-per-meter">{{ number_format($flat->price / $flat->area, 0, ',', ' ') }} ₽/м²</div>
                        
                        @if($flat->priceHistory && $flat->priceHistory->count() > 0)
                        <div class="price-history-section mt-3">
                            <a href="javascript:void(0);" class="btn-primary w-100 d-flex align-items-center justify-content-between" onclick="togglePriceHistory()">
                                <span>Показать историю цен</span><span class="toggle-icon">▼</span>
                            </a>
                            <div class="price-chart-container mt-3" id="priceHistoryContainer" style="display: none;">
                                <div id="price_chart_{{ $flat->id }}" style="width: 100%; height: 200px;"></div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-secondary small py-2 mb-3">📈 Нет данных об изменении цены</div>
                        @endif
                        
                        <hr class="mt-4">
                        
                        @if($flat->is_available && $flat->status == 'available')
                        <div class="d-grid gap-2 mb-3">
                            <a href="#" class="btn-primary w-100" onclick="openCallRequestModal(); return false;">📞 Заказать звонок</a>
                        </div>
                        @elseif($flat->status == 'reserved')
                        <div class="alert alert-warning"><h5>⏳ Квартира забронирована</h5><p class="mb-0">Эта квартира временно недоступна для покупки.</p></div>
                        @else
                        <div class="alert alert-secondary"><h5>✅ Квартира продана</h5><p class="mb-0">Эта квартира уже продана.</p></div>
                        @endif
                        
                        @auth
                        <a href="#" class="btn-booking" onclick="openBookingModal()"> Записаться на просмотр</a>
                        @else
                        <a href="{{ route('login') }}" class="btn-booking"> Войдите для записи</a>
                        @endauth
                        
                        <hr>
                        <div class="contact-info">
                            <h6 class="mb-3">Контакты отдела продаж:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">📞 <strong>+7 (495) 123-45-67</strong></li>
                                <li class="mb-2">✉️ sales@example.com</li>
                                <li>🕒 Пн-Пт: 9:00-20:00</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Похожие квартиры</h5>
                        @if($similarFlats->count() > 0)
                            @foreach($similarFlats as $similar)
                            <a href="{{ route('flats.show', $similar->id) }}" class="similar-flat-item">
                                <div class="d-flex justify-content-between">
                                    <h6>{{ $similar->title }}</h6>
                                    <small>{{ number_format($similar->price, 0, ',', ' ') }} ₽</small>
                                </div>
                                <small>{{ $similar->area }} м², {{ $similar->floor }}/{{ $similar->total_floors }} эт.</small>
                            </a>
                            @endforeach
                        @else
                            <p class="text-muted small mb-0">Нет похожих квартир</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальные окна -->
    <div id="imageModal" class="modal">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <a href="javascript:void(0)" class="modal-close" onclick="closeImageModal()">×</a>
            </div>
            <div class="modal-body">
                <img id="fullscreenImage" src="" class="img-fluid">
            </div>
        </div>
    </div>

    <div id="callRequestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Новая заявка на звонок</h3>
                <a href="javascript:void(0)" class="modal-close" onclick="closeCallRequestModal()">×</a>
            </div>
            <form action="{{ route('applications.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="flat_id" value="{{ $flat->id }}">
                    <div class="form-group">
                        <label class="form-label">Ваше имя</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Номер телефона</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+7 (___) ___-__-__" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Комментарий (необязательно)</label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn-secondary" onclick="closeCallRequestModal()">Отмена</a>
                    <a href="javascript:void(0)" class="btn-primary" onclick="document.getElementById('callRequestForm').submit();">Отправить заявку</a>
                </div>
            </form>
        </div>
    </div>

    <div id="bookingModal" class="booking-modal">
        <div class="booking-modal-content" style="max-width: 520px; width: 90%;">
            <div class="booking-modal-header">
                <h3>Выберите дату и время</h3>
                <a href="javascript:void(0)" class="booking-modal-close" onclick="closeBookingModal()">&times;</a>
            </div>
            
            <div class="booking-modal-body" style="padding: 20px;">
                <div class="calendar-container" style="margin-bottom: 15px;">
                    <div class="calendar-header" style="margin-bottom: 12px;">
                        <a href="javascript:void(0)" class="calendar-nav" onclick="changeMonth(-1)">‹</a>
                        <span id="currentMonthYear"></span>
                        <a href="javascript:void(0)" class="calendar-nav" onclick="changeMonth(1)">›</a>
                    </div>
                    <div class="calendar-weekdays" style="margin-bottom: 10px; font-size: 13px;">
                        <span>Пн</span><span>Вт</span><span>Ср</span><span>Чт</span><span>Пт</span><span>Сб</span><span>Вс</span>
                    </div>
                    <div id="calendarDays" class="calendar-days" style="gap: 4px;"></div>
                </div>
                
                <div id="timeContainer" style="display: none;">
                    <div class="time-label" style="margin-bottom: 10px; font-size: 14px;">Доступное время</div>
                    <div id="timeSlots" class="time-slots" style="gap: 8px;"></div>
                </div>
                
                <div id="bookingSuccess" class="booking-success" style="display: none; padding: 15px;">

                    <h4 style="font-size: 18px;">Запись создана!</h4>
                </div>
            </div>
            
            <div class="booking-modal-footer" id="bookingFooter" style="padding: 15px;">
                <a href="javascript:void(0)" class="booking-btn-cancel" onclick="closeBookingModal()" style="padding: 8px 20px;">Отмена</a>
                <a href="javascript:void(0)" class="booking-btn-submit" onclick="submitBooking()" id="submitBtn" style="padding: 8px 20px;">Записаться</a>
            </div>
        </div>
    </div>

    <form id="bookingForm" style="display: none;">
        @csrf
        <input type="hidden" name="flat_id" value="{{ $flat->id }}">
        <input type="hidden" name="date" id="selectedDate">
        <input type="hidden" name="time" id="selectedTime">
    </form>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #f5f5f5;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.col-lg-8, .col-lg-4, .col-md-6 {
    padding: 0 15px;
}

.col-lg-8 { width: 66.666%; }
.col-lg-4 { width: 33.333%; }
.col-md-6 { width: 50%; }

@media (max-width: 992px) {
    .col-lg-8, .col-lg-4 { width: 100%; }
    .col-md-6 { width: 100%; }
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.card-body { padding: 20px; }
.card-body.p-0 { padding: 0; }
.mb-4 { margin-bottom: 20px; }
.mt-3 { margin-top: 15px; }
.mt-4 { margin-top: 20px; }
.mb-3 { margin-bottom: 15px; }
.mb-2 { margin-bottom: 10px; }
.mb-0 { margin-bottom: 0; }
.me-2 { margin-right: 10px; }
.py-5 { padding: 40px 0; }

.h3 { font-size: 1.75rem; }
.h6 { font-size: 1rem; }

.text-muted { color: #6c757d; }
.text-center { text-align: center; }

.breadcrumb {
    padding: 15px 0;
    list-style: none;
}
.breadcrumb-item {
    display: inline;
}
.breadcrumb-item a {
    color: #1a3b2e;
    text-decoration: none;
}
.breadcrumb-item + .breadcrumb-item:before {
    content: "/";
    padding: 0 8px;
    color: #999;
}

.btn-primary, .btn-secondary, .btn-booking {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: background 0.2s;
}
.btn-primary {
    background: #1a3b2e;
    color: white;
}
.btn-primary:hover { background: #0f2b21; }
.btn-secondary {
    background: #e0e0e0;
    color: #333;
}
.btn-secondary:hover { background: #d0d0d0; }
.btn-booking {
    display: block;
    width: 100%;
    padding: 12px;
    background: #1a3b2e;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}
.w-100 { width: 100%; }
.d-grid { display: grid; }
.gap-2 { gap: 10px; }

.form-group { margin-bottom: 15px; }
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
}
.form-control:focus {
    outline: none;
    border-color: #1a3b2e;
}

.carousel {
    position: relative;
    overflow: hidden;
}
.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
}
.carousel-item {
    position: relative;
    display: none;
    width: 100%;
}
.carousel-item.active {
    display: block;
}/* Стрелки слайдера */
.carousel-control-prev,
.carousel-control-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    padding: 12px 16px;
    cursor: pointer;
    z-index: 5;
    text-decoration: none;
    font-size: 20px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(0,0,0,0.8);
}

.carousel-control-prev {
    left: 15px;
}

.carousel-control-next {
    right: 15px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-size: 100%;
}

.carousel-control-prev-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
}

.carousel-control-next-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
}

.parameters-list li {
    padding: 6px 0;
    border-bottom: 1px solid #f0f0f0;
}
.parameters-list li:last-child { border-bottom: none; }
.d-flex { display: flex; }
.justify-content-between { justify-content: space-between; }
.align-items-center { align-items: center; }
.align-items-start { align-items: flex-start; }

.price {
    font-size: 24px;
    color: #1a3b2e;
    font-weight: 600;
}
.price-per-meter {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 15px;
}

.favorite-link {
    display: inline-block;
    width: 24px;
    height: 24px;
}
.favorite-link img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.favorite-link.active img {
    filter: invert(27%) sepia(94%) hue-rotate(355deg);
}

.description-content {
    position: relative;
    overflow: hidden;
    transition: max-height 0.3s;
}
.description-content.collapsed { max-height: 100px; }
.description-content.expanded { max-height: 2000px; }
.description-link {
    color: #1a3b2e;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
}
.d-none { display: none; }

.price-history-section a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
}
.toggle-icon { transition: transform 0.3s; }

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
    font-size: 18px;
    font-weight: 500;
}
.modal-close {
    font-size: 24px;
    color: #999;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: none;
}
.modal-close:hover { color: #333; }
.modal-body { padding: 20px; }
.modal-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.similar-flat-item {
    display: block;
    padding: 10px;
    margin-bottom: 5px;
    border-bottom: 1px solid #f0f0f0;
    text-decoration: none;
    color: inherit;
}
.similar-flat-item:hover { background: #f9f9f9; }

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #1a3b2e;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    z-index: 9999;
    animation: slideIn 0.3s;
}
@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

.no-photo-icon {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 10px;
}
.success-icon {
    font-size: 60px;
    color: #28a745;
    margin-bottom: 20px;
}

.alert {
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
}
.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffeeba;
    color: #856404;
}
.alert-secondary {
    background: #f8f9fa;
    border: 1px solid #d6d8db;
    color: #383d41;
}

.booking-modal {
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

.booking-modal-content {
    background: white;
    width: 90%;
    max-width: 520px;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    overflow: hidden;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
}

.booking-modal-header {
    padding: 12px 16px;
    background: #1a3b2e;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.booking-modal-header h3 {
    margin: 0;
    font-size: 16px;
}

.booking-modal-close {
    background: none;
    border: none;
    font-size: 22px;
    color: white;
    cursor: pointer;
    text-decoration: none;
}

.booking-modal-body {
    padding: 12px 16px;
    overflow-y: auto;
    flex: 1;
}

.calendar-container {
    margin-bottom: 12px;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.calendar-nav {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: #1a3b2e;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    text-align: center;
    line-height: 28px;
    text-decoration: none;
    display: inline-block;
}

.calendar-nav:hover {
    background: #f0f0f0;
}

#currentMonthYear {
    font-size: 14px;
    font-weight: 600;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    margin-bottom: 6px;
    font-weight: 600;
    color: #666;
    font-size: 11px;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 3px;
}

.calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s;
}

.calendar-day:hover {
    background: #f0f0f0;
}

.calendar-day.selected {
    background: #1a3b2e;
    color: white;
}

.calendar-day.disabled {
    color: #ccc;
    cursor: not-allowed;
    background: none;
}

.calendar-day.weekend {
    color: #999;
}

.time-label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
    font-size: 12px;
}

.time-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.time-slot {
    padding: 5px 12px;
    border: 1.5px solid #e0e0e0;
    border-radius: 25px;
    background: white;
    cursor: pointer;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s;
}

.time-slot:hover {
    border-color: #1a3b2e;
    background: #f5f5f5;
}

.time-slot.selected {
    background: #1a3b2e;
    color: white;
    border-color: #1a3b2e;
}

.booking-success {
    text-align: center;
    padding: 20px 10px;
}

.success-icon {
    font-size: 40px;
    color: #28a745;
    margin-bottom: 8px;
}

.booking-success h4 {
    font-size: 16px;
    margin-bottom: 5px;
}

.booking-success p {
    font-size: 12px;
    color: #666;
}

.booking-modal-footer {
    padding: 10px 16px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    flex-shrink: 0;
    background: white;
}

.booking-btn-cancel,
.booking-btn-submit {
    padding: 6px 16px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
}

.booking-btn-cancel {
    background: #e0e0e0;
    color: #333;
}

.booking-btn-cancel:hover {
    background: #d0d0d0;
}

.booking-btn-submit {
    background: #1a3b2e;
    color: white;
}

.booking-btn-submit:hover {
    background: #0f2b21;
}

.booking-btn-submit.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

</style>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
let currentDate = new Date();
let currentYear = currentDate.getFullYear();
let currentMonth = currentDate.getMonth();
let selectedDate = null;
let selectedTime = null;

function openBookingModal() {
    document.getElementById('bookingModal').style.display = 'flex';
    renderCalendar();
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
    resetForm();
}

function resetForm() {
    selectedDate = null;
    selectedTime = null;
    document.getElementById('timeContainer').style.display = 'none';
    document.getElementById('bookingSuccess').style.display = 'none';
    document.getElementById('bookingFooter').style.display = 'flex';
    document.getElementById('submitBtn').classList.add('disabled');
}

function changeMonth(delta) {
    currentMonth += delta;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
}

function renderCalendar() {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
    const startDay = firstDayOfMonth.getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    
    const monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
    document.getElementById('currentMonthYear').textContent = `${monthNames[currentMonth]} ${currentYear}`;
    
    let daysHtml = '';
    const offset = startDay === 0 ? 6 : startDay - 1;
    for (let i = 0; i < offset; i++) {
        daysHtml += '<div class="calendar-day disabled"></div>';
    }
    
    for (let day = 1; day <= daysInMonth; day++) {
        const cellDate = new Date(currentYear, currentMonth, day);
        const dayOfWeek = cellDate.getDay();
        const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
        const isPast = cellDate < today;
        const isSelected = selectedDate === `${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        
        let classes = 'calendar-day';
        if (isWeekend) classes += ' weekend';
        if (isPast) classes += ' disabled';
        if (isSelected) classes += ' selected';
        
        daysHtml += `<div class="${classes}" data-year="${currentYear}" data-month="${currentMonth+1}" data-day="${day}" onclick="${!isPast && !isWeekend ? `selectDate(${currentYear}, ${currentMonth+1}, ${day})` : ''}">${day}</div>`;
    }
    
    document.getElementById('calendarDays').innerHTML = daysHtml;
}

function selectDate(year, month, day) {
    const dateStr = `${year}-${String(month).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
    selectedDate = dateStr;
    document.getElementById('selectedDate').value = dateStr;
    
    document.querySelectorAll('.calendar-day').forEach(el => {
        el.classList.remove('selected');
        if (el.getAttribute('data-year') == year && el.getAttribute('data-month') == month && el.getAttribute('data-day') == day) {
            el.classList.add('selected');
        }
    });
    
    document.getElementById('timeContainer').style.display = 'block';
    document.getElementById('timeSlots').innerHTML = '<div style="color:#999; text-align:center;">Загрузка...</div>';
    document.getElementById('submitBtn').classList.add('disabled');
    selectedTime = null;
    
    fetch(`/appointments/slots?date=${dateStr}`)
        .then(response => response.json())
        .then(slots => {
            if (!slots || slots.length === 0) {
                document.getElementById('timeSlots').innerHTML = '<div style="color:#999; text-align:center;">Нет свободного времени</div>';
                return;
            }
            
            let html = '';
            slots.forEach(time => {
                html += `<div class="time-slot" onclick="selectTime('${time}')">${time}</div>`;
            });
            document.getElementById('timeSlots').innerHTML = html;
        })
        .catch(error => {
            console.error('Ошибка:', error);
            document.getElementById('timeSlots').innerHTML = '<div style="color:red; text-align:center;">Ошибка загрузки</div>';
        });
}

function selectTime(time) {
    document.querySelectorAll('.time-slot').forEach(el => {
        el.classList.remove('selected');
    });
    event.target.classList.add('selected');
    selectedTime = time;
    document.getElementById('selectedTime').value = time;
    document.getElementById('submitBtn').classList.remove('disabled');
}

function submitBooking() {
    if (!selectedDate || !selectedTime) {
        alert('Выберите дату и время');
        return;
    }
    
    const btn = document.getElementById('submitBtn');
    btn.classList.add('disabled');
    btn.textContent = 'Отправка...';
    
    fetch('{{ route("appointments.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            flat_id: {{ $flat->id }},
            date: selectedDate,
            time: selectedTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('bookingFooter').style.display = 'none';
            document.getElementById('bookingSuccess').style.display = 'block';
            setTimeout(() => {
                closeBookingModal();
            }, 2000);
        } else {
            alert(data.message || 'Ошибка при создании записи');
            btn.classList.remove('disabled');
            btn.textContent = 'Записаться';
        }
    })
    .catch(error => {
        alert('Произошла ошибка');
        btn.classList.remove('disabled');
        btn.textContent = 'Записаться';
    });
}

function toggleDescription() {
    const content = document.getElementById('descriptionContent');
    const showMore = document.getElementById('showMoreLink');
    const showLess = document.getElementById('showLessLink');
    
    if (content.classList.contains('collapsed')) {
        content.classList.replace('collapsed', 'expanded');
        showMore.classList.add('d-none');
        showLess.classList.remove('d-none');
    } else {
        content.classList.replace('expanded', 'collapsed');
        showMore.classList.remove('d-none');
        showLess.classList.add('d-none');
    }
}

google.charts.load('current', { packages: ['corechart'] });
function drawPriceChart() {
    const data = new google.visualization.DataTable();
    data.addColumn('string', 'Дата');
    data.addColumn('number', 'Цена');
    data.addRows([
        @foreach($flat->priceHistory as $history)
        ['{{ $history->date->format('d.m') }}', {{ $history->price }}],
        @endforeach
    ]);
    
    new google.visualization.LineChart(
        document.getElementById('price_chart_{{ $flat->id }}')
    ).draw(data, {
        legend: { position: 'none' },
        colors: ['#7b5141'],
        pointSize: 6,
        chartArea: { left: 50, top: 20, width: '80%', height: '70%' }
    });
}

function togglePriceHistory() {
    const container = document.getElementById('priceHistoryContainer');
    const btn = document.querySelector('.price-history-section a span:first-child');
    const icon = document.querySelector('.price-history-section .toggle-icon');
    
    if (container.style.display === 'none') {
        container.style.display = 'block';
        btn.textContent = ' Скрыть историю цен';
        icon.textContent = '▲';
        setTimeout(drawPriceChart, 100);
    } else {
        container.style.display = 'none';
        btn.textContent = ' Показать историю цен';
        icon.textContent = '▼';
    }
}

function openCallRequestModal() {
    document.getElementById('callRequestModal').style.display = 'flex';
}
function closeCallRequestModal() {
    document.getElementById('callRequestModal').style.display = 'none';
}

function showFullImage(url) {
    document.getElementById('fullscreenImage').src = url;
    document.getElementById('imageModal').style.display = 'flex';
}
function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

function toggleFavorite(flatId) {
    @auth
    fetch(`/profile/favorites/toggle/${flatId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.querySelector(`.favorite-link[data-flat-id="${flatId}"]`);
            btn.classList.toggle('active');
            showNotification(data.added ? 'Добавлено в избранное' : 'Удалено из избранного');
        }
    });
    @endauth
}

function showNotification(msg) {
    const notif = document.createElement('div');
    notif.className = 'notification';
    notif.textContent = msg;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
}

window.onclick = function(e) {
    ['bookingModal', 'callRequestModal', 'imageModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) modal.style.display = 'none';
    });
}
// Управление слайдером
let currentSlide = 0;
let slides = document.querySelectorAll('.carousel-item');

function updateSlides() {
    slides.forEach((slide, index) => {
        if (index === currentSlide) {
            slide.classList.add('active');
        } else {
            slide.classList.remove('active');
        }
    });
}

function nextSlide() {
    if (slides.length === 0) return;
    currentSlide = (currentSlide + 1) % slides.length;
    updateSlides();
}

function prevSlide() {
    if (slides.length === 0) return;
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateSlides();
}

// Инициализация слайдера
setTimeout(() => {
    slides = document.querySelectorAll('.carousel-item');
    updateSlides();
}, 100);
</script>
@endsection