@extends('layouts.app')

@section('title', 'Жилой комплекс "ESTATE" - квартиры в Казани')
@section('content')

{{-- каталог квартир --}}
<section class="catalog" id="catalog">
    <div class="filter-bg">
    <div class="container">
           <div class="filter-setion">
        <div class="section-header">
            <h2>Квартиры в продаже</h2>
            <p>{{$flats->total()}} квартир доступно для покупки</p>
        </div>
    
        {{-- фильтр --}}
     
            <form action="{{ route('flats.index') }}" method="GET" class="filter-form">
                <div class="filter-grid">
                    <div class="filter-item">
                        <select name="rooms" id="roooms" >
                            <option value="" disabled selected>Количество комнат</option> <!-- плейсхолдер -->
                         <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1 комната</option>
                         <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2 комнаты</option>
                         <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3 комнаты</option>
                         <option value="4" {{ request('rooms') == '4' ? 'selected' : '' }}>4+ комнаты</option>
                        </select>
                    </div>
    
                    <div class="filter-item">
                        <input type="number" name="max_price" value="{{ request('max_price')}}"     placeholder="Цена до, ₽" min="1000000" >
                    </div>
                    <div class="filter-item">
                        <input type="number" name="min_area" value="{{ request('min_area') }}"       placeholder="Площадь от, м²"  >
                    </div>
                    <div class="filter-item filter-actions">
                        <button type="submit"class="btn form-btn">Показать</button>
                        <a href="{{ route('flats.index') }}" class="btn  form-btn filter-reset">Сбросить</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
@endsection