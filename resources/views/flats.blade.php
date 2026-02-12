@extends('layouts.app')

@section('title', 'Квартиры в продаже')
@section('content')
<div class="flats-page">
    <!-- Заголовок -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Подберём и поможем купить новостройку</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Фильтр -->
        <div class="filter-section">
            <h5 class="card-title"> Поиск квартир</h5>
            <form action="#" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Количество комнат</label>
                    <select class="form-select" name="rooms">
                        <option value="">Любое</option>
                        <option value="1">1 комната</option>
                        <option value="2">2 комнаты</option>
                        <option value="3">3 комнаты</option>
                        <option value="4">4+ комнаты</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Тип жилья</label>
                    <select class="form-select" name="housing_type">
                        <option value="">Любой</option>
                        <option value="new_building">Новостройка</option>
                        <option value="secondary">Вторичное</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Цена до</label>
                    <input type="number" class="form-control" name="max_price" placeholder="Макс. цена, руб">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Найти квартиры</button>
                </div>
            </form>
        </div>

        <!-- Список квартир -->
        @if($flats->count() > 0)
        <div class="row">
            @foreach($flats as $flat)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 flat-card">
                    <div class="card-header">
                        <span class="badge bg-{{ $flat->housing_type == 'new_building' ? 'success' : 'info' }}">
                            {{ $flat->housing_type_text }}
                        </span>
                        <span class="badge bg-warning float-end">{{ $flat->rooms }}-комн.</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $flat->title }}</h5>
                        <div class="price-section mb-3">
                            <h4 class="text-primary">{{ $flat->formatted_price }}</h4>
                            <div class="text-muted small">
                                {{ number_format($flat->price / $flat->area, 0, ',', ' ') }} ₽/м²
                            </div>
                        </div>
                        
                        <div class="flat-characteristics">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Площадь</small>
                                    <div><strong>{{ $flat->area }} м²</strong></div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Этаж</small>
                                    <div><strong>{{ $flat->floor }}/{{ $flat->total_floors }}</strong></div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-6">
                                    <small class="text-muted">Отделка</small>
                                    <div><strong>{{ $flat->finishing_text }}</strong></div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Вид</small>
                                    <div><strong>{{ $flat->view_type_text }}</strong></div>
                                </div>
                            </div>
                        </div>

                        <p class="card-text mt-3 small text-muted">
                            {{ Str::limit($flat->description, 120) }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('flats.show', $flat->id) }}" class="btn btn-outline-primary btn-sm">
                                Подробнее
                            </a>
                            <div class="flat-features">
                                @if($flat->balcony)
                                    <span class="badge bg-light text-dark" title="Есть балкон">есть балкон</span>
                                @endif
                                <span class="badge bg-light text-dark" title="{{ $flat->bathroom_text }} санузел">есть санузел</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $flats->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4> Квартиры не найдены</h4>
                    <p>В данный момент нет доступных квартир для продажи.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection