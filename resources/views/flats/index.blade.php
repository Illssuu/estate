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

    @if($flats->count() > 0)
    <div class="flats-grid">
        @foreach($flats as $flat)
        <div class="flat-card">
            <!-- ФОТОГРАФИИ -->
            <div class="flat-card-image">
                @if($flat->photos->first())
                    <img src="{{ Storage::url($flat->photos->first()->image_path) }}" 
                         alt="{{ $flat->title }}"
                         style="max-width: 100%;">
                @else
                    <div class="no-image">Нет фото</div>
                @endif
            </div>
            <div class="flat-card-body">
                <div class="flat-type {{ $flat->housing_type == 'new_building' ? 'new-building' : 'secondary' }}">
                    {{ $flat->housing_type == 'new_building' ? 'Новостройка' : 'Вторичка' }}
                </div>
                
                <h3 class="flat-title">{{ $flat->rooms }}-комнатная квартира</h3>
                
                <div class="flat-price">
                    {{ number_format($flat->price, 0, '.', ' ') }} ₽
                </div>
                
                <div class="flat-vertical-features">
                    <span>{{ $flat->rooms }}-комн.</span>
                    <span class="dot">•</span>
                    <span>Этаж {{ $flat->floor ?? '2' }}/{{ $floors ?? '13' }}</span>
                    <span class="dot">•</span>
                    <span>{{ $flat->area ?? '79' }} м²</span>
                </div>
                <a href="{{ route('flats.show', $flat) }}" class=" flat-details-btn">Подробнее</a>
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


@endsection