@extends('layouts.admin')

@section('title', 'Управление квартирами')
@section('header', 'Квартиры')

@section('content')
<div class="actions-bar">
    <a href="{{ route('admin.flats.create') }}" class="btn btn-primary">+ Добавить квартиру</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Комнат</th>
            <th>Площадь</th>
            <th>Цена</th>
            <th>Статус</th>
            <th>Действия</th>  {{-- Новая колонка --}}
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
            <td>
                <a href="{{ route('admin.flats.edit', $flat) }}" class="btn-edit"> Редактировать</a>
                
                <form action="{{ route('admin.flats.destroy', $flat) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Точно удалить эту квартиру?')">
                         Удалить
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $flats->links() }}
</div>
@endsection