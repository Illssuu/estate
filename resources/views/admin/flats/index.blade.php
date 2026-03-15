<!-- resources/views/admin/flats/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Управление квартирами')
@section('header', 'Квартиры')

@section('content')
<div class="actions-bar">
    <a href="{{ route('admin.flats.create') }}" class="btn btn-primary">+ Добавить квартиру</a>
    
    <!-- Форма поиска -->
    <form method="GET" action="{{ route('admin.flats.index') }}" class="search-form">
        <div class="search-wrapper">
            <input 
                type="text" 
                name="search" 
                placeholder="Поиск по названию квартиры..." 
                value="{{ request('search') }}"
                class="search-input"
            >
            <button type="submit" class="search-btn">Найти</button>
               @if(request('search'))
        <a href="{{ route('admin.flats.index', array_merge(request()->except('search', 'page'))) }}" class="search-clear">✕</a>
    @endif
        </div>
    </form>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        ID
                        @if($sort == 'id') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'title', 'order' => ($sort == 'title' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        Название
                        @if($sort == 'title') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'rooms', 'order' => ($sort == 'rooms' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        Комнат
                        @if($sort == 'rooms') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'area', 'order' => ($sort == 'area' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        Площадь
                        @if($sort == 'area') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'price', 'order' => ($sort == 'price' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        Цена
                        @if($sort == 'price') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', array_merge(request()->except('sort', 'order'), ['sort' => 'status', 'order' => ($sort == 'status' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="sort-link">
                        Статус
                        @if($sort == 'status') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flats as $flat)
            <tr>
                <td>{{ $flat->id }}</td>
                <td>{{ $flat->title }}</td>
                <td>{{ $flat->rooms }}</td>
                <td>{{ $flat->area }} м²</td>
                <td>{{ number_format($flat->price, 0, '.', ' ') }} ₽</td>
                <td>
                    @if($flat->status == 'available')
                        <span class="badge available">Доступна</span>
                    @elseif($flat->status == 'sold')
                        <span class="badge sold">Продана</span>
                    @else
                        <span class="badge booked">Забронирована</span>
                    @endif
                </td>
                <td class="actions">
                    <a href="{{ route('admin.flats.edit', $flat) }}" class="btn-edit">Ред.</a>
                    <form action="{{ route('admin.flats.destroy', $flat) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Удалить?')">Удал.</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center empty-message">
                    @if(request('search'))
                        Квартиры по запросу "{{ request('search') }}" не найдены
                    @else
                        Квартиры не найдены
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($flats->hasPages())
<div class="pagination-wrapper">
    {{ $flats->withQueryString()->links('pagination::bootstrap-4') }}
</div>
@endif


<style>
    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 260px;
    }



    .btn-primary:hover {
        background: #0f2b21;
        color: white;
    }

    .btn-primary:focus,
    .btn-primary:active {
        background: #1A3B2E;
        color: white;
        outline: none;
        box-shadow: 0 0 0 3px rgba(26, 59, 46, 0.3);
    }

    .search-form {
        flex: 1;
        max-width: 400px;
    }

    .search-wrapper {
        display: flex;
        align-items: center;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px;
        padding-right: 100px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #1A3B2E;
        box-shadow: 0 0 0 3px rgba(26, 59, 46, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 5px;
        padding: 8px 16px;
        background: #1A3B2E;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .search-btn:hover {
        background: #0f2b21;
    }

    .search-btn:focus,
    .search-btn:active {
        background: #1A3B2E;
        outline: none;
        box-shadow: 0 0 0 3px rgba(26, 59, 46, 0.3);
    }

    .search-clear {
        position: absolute;
        right: 75px;
        color: #999;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        padding: 5px;
    }


</style>
@endsection