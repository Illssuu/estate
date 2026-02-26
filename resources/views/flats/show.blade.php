@extends('layouts.app')

@section('title', $flat->title . ' - Квартира в продаже')
@section('content')
<div class="flat-detail-page">
    <!-- Хлебные крошки -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('flats.index') }}">Квартиры</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $flat->title }}</li>
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
                        
                        <!-- Цена -->
                        <div class="price-section mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted">Цена:</span>
                                <h2 class="text-primary mb-0">{{ $flat->formatted_price }}</h2>
                                <span class="text-muted">
                                    ({{ number_format($flat->price / $flat->area, 0, ',', ' ') }} ₽/м²)
                                </span>
                            </div>
                        </div>


                        <!-- Основные параметры в список -->
                        <div class="parameters-list mb-4">
                            <div class="row">
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

                        <!-- Описание (в самом конце) -->
                        @if($flat->description)
                            <div class="description">
                                <p class="text-justify">{{ $flat->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="col-lg-4">
                <!-- Действия -->
                <div class="card mb-4">
                    <div class="card-body">
                        @if($flat->is_available && $flat->status == 'available')
                            <div class="d-grid gap-2 mb-3">
                                <a href="">Заказать звонок</a>
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
</div>

<style>
.parameters-list li {
    padding: 6px 0;
    border-bottom: 1px solid #f0f0f0;
}
.parameters-list li:last-child {
    border-bottom: none;
}
</style>
@endsection