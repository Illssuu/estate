<!-- resources/views/admin/flats/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Управление квартирами')
@section('header', 'Квартиры')

@section('content')
<div class="actions-bar">
    <a href="{{ route('admin.flats.create') }}" class="btn btn-primary">+ Добавить квартиру</a>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        ID
                        @if($sort == 'id') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'title', 'order' => ($sort == 'title' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        Название
                        @if($sort == 'title') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'rooms', 'order' => ($sort == 'rooms' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        Комнат
                        @if($sort == 'rooms') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'area', 'order' => ($sort == 'area' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        Площадь
                        @if($sort == 'area') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'price', 'order' => ($sort == 'price' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        Цена
                        @if($sort == 'price') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.flats.index', ['sort' => 'status', 'order' => ($sort == 'status' && $order == 'asc') ? 'desc' : 'asc']) }}" class="sort-link">
                        Статус
                        @if($sort == 'status') <span class="sort-arrow">{{ $order == 'asc' ? '↑' : '↓' }}</span> @endif
                    </a>
                </th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flats as $flat)
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
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $flats->withQueryString()->links() }}
</div>


@endsection