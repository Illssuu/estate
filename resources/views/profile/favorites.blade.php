@extends('layouts.app')

@section('title', 'Избранные квартиры')
@section('content') 
<div class="favorites-page">
    <div class="container">
        <div class="favorites-header">
            <h1>Избранные квартиры</h1>
            <span class="favorites-count">{{ $favorites->total() }} квартир</span>
        </div>

        @if($favorites->count() > 0)
            <div class="favorites-grid">
                @foreach($favorites as $flat) 
                    <div class="favorite-card" id="flat-{{ $flat->id }}">
                        <div class="favorite-card-header">
                            <span class="badge badge-{{ $flat->housing_type }}">
                                {{ $flat->housing_type == 'new_building' ? 'Новостройка' : 'Вторичка' }}
                            </span>
                            <span class="badge badge-rooms">{{ $flat->rooms }}-комн.</span>
                        </div>

                        <div class="favorite-card-body">
                            <h3 class="favorite-title">{{ $flat->title }}</h3>
                            
                            <div class="favorite-price">
                                <span class="price-value">{{ number_format($flat->price, 0, '.', ' ') }} ₽</span>
                                <span class="price-meter">{{ number_format($flat->price / $flat->area, 0, '.', ' ') }} ₽/м²</span>
                            </div>

                            <div class="favorite-specs">
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
                                    <span class="spec-value">{{ $flat->finishing_text }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="favorite-card-footer">
                            <a href="{{ route('flats.show', $flat->id) }}" class="btn btn-primary">Подробнее</a>
                            <button class="btn-remove" data-flat-id="{{ $flat->id }}" onclick="toggleFavorite({{ $flat->id }})">
                                ✕ Удалить
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="empty-state">
                <h3>В избранном пока пусто</h3>
                <p>Добавляйте понравившиеся квартиры, чтобы не потерять</p>
                <a href="{{ route('flats.index') }}" class="btn btn-primary">Перейти к каталогу</a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleFavorite(flatId) {
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
        if (data.success && !data.added) {
            document.getElementById(`flat-${flatId}`).remove();

            if (document.querySelectorAll('.favorite-card').length === 0) {
                location.reload();
            }
        }
    });
}
</script>

<style>
/* Основные стили */
.favorites-page {
    padding: 40px 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Заголовок */
.favorites-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background: white;
    padding: 20px 25px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.favorites-header h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 500;
    color: #333;
}

.favorites-count {
    padding: 6px 15px;
    background: #f0f0f0;
    border-radius: 20px;
    font-size: 14px;
    color: #666;
}

/* Сетка карточек */
.favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

/* Карточка квартиры */
.favorite-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}

.favorite-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.favorite-card-header {
    padding: 15px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* Бейджи */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge-new_building {
    background: #2c3e50;
    color: white;
}

.badge-secondary {
    background: #f39c12;
    color: white;
}

.badge-rooms {
    background: #e0e0e0;
    color: #333;
}

/* Тело карточки */
.favorite-card-body {
    padding: 20px;
}

.favorite-title {
    margin: 0 0 15px;
    font-size: 18px;
    font-weight: 500;
    color: #333;
    line-height: 1.4;
}

/* Цена */
.favorite-price {
    margin-bottom: 20px;
}

.price-value {
    display: block;
    font-size: 22px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 4px;
}

.price-meter {
    font-size: 13px;
    color: #999;
}

/* Характеристики */
.favorite-specs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    padding: 15px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.spec-item {
    text-align: center;
}

.spec-label {
    display: block;
    font-size: 11px;
    color: #999;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.spec-value {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

/* Подвал карточки */
.favorite-card-footer {
    padding: 15px 20px;
    background: #f8f9fa;
    display: flex;
    gap: 10px;
}

/* Кнопки */
.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background: #2c3e50;
    color: white;
    flex: 2;
}

.btn-primary:hover {
    background: #1e2b37;
}

.btn-remove {
    flex: 1;
    background: #fee;
    color: #c00;
    border: 1px solid #fcc;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-remove:hover {
    background: #fcc;
    color: #900;
}

/* Пагинация */
.pagination-wrapper {
    margin-top: 40px;
    text-align: center;
}

.pagination-wrapper .pagination {
    display: inline-flex;
    gap: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-wrapper .page-item {
    display: inline-block;
}

.pagination-wrapper .page-link {
    display: block;
    padding: 8px 12px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    color: #333;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-wrapper .page-link:hover {
    background: #f0f0f0;
}

.pagination-wrapper .active .page-link {
    background: #2c3e50;
    color: white;
    border-color: #2c3e50;
}

/* Пустое состояние */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.empty-state-icon {
    font-size: 48px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    margin: 0 0 10px;
    font-size: 20px;
    font-weight: 500;
    color: #333;
}

.empty-state p {
    margin: 0 0 25px;
    color: #999;
}

/* Адаптивность */
@media (max-width: 768px) {
    .favorites-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .favorites-grid {
        grid-template-columns: 1fr;
    }
    
    .favorite-card-footer {
        flex-direction: column;
    }
    
    .btn-primary, .btn-remove {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .favorite-specs {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .favorite-card-header {
        justify-content: center;
    }
}
</style>
@endsection