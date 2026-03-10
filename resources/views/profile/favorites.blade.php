@extends('layouts.app')

@section('title', 'Избранные квартиры')
@section('content') 
<div class="container">
    <div class="favorites-title">
        <h1>Избранные квартиры</h1>
        <span>{{ $favorites->total() }} квартир</span>
    </div>

    @if($favorites->count() > 0)
    <div class="favorites-grid">
        @foreach($favorites as $flat) 
        <div class="favorites-card" id="flat-{{ $flat->id}}">
            <div class="favorite-card-header">
            <span class="badge bg-{{ $flat->housing_type == 'new_building' ? 'success' : 'info' }}">
                {{ $flat->housing_type == 'new_building' ? 'Новостройка' : 'Вторичка' }}
            </span>
            <span class="badge bg-warning">{{ $flat->rooms }}-комн.</span>
          </div>
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

            <div class="favorite-card-footer">
                <a href="{{ route('flats.show', $flat->id) }}" class="btn btn-primary">Подробнее</a>
                <button  data-flat-id="{{ $flat->id }}" onclick="toggleFavorite({{ $flat->id }})">
                Удалить
                </button>
            </div>
    </div>
    @endforeach
</div>

<div class="pagination-wrapper">
    {{ $favorites->links() }}
</div>
@else
    <div class="epty-state">
        <h3>В избранном пусто</h3>
         <p>Добавляйте понравившиеся квартиры в избранное, чтобы не потерять</p>

         <a href="{{ route('flats.index') }}" class="btn btn-primary">Перейти к каталогу</a>
    </div>
    @endif
</div>
</div>


<script>
  function toggleFavorite(flatId) {
    fetch(`/profile/favorite/toggle/$(flatId)`, {
        method: 'POST', 
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && !data.added) {
            document.getElementById(`flat-${flatId}`).remove();

            if (document.querySelectionAll('.favorite-card').length === 0) {
                location.reload();
            }
        }
    });
  }  
</script>