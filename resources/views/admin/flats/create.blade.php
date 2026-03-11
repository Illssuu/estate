@extends('layouts.admin')

@section('title', 'Добавление квартиры')
@section('header', 'Добавить новую квартиру')

@section('content')
<form action="{{ route('admin.flats.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="title" required>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Комнат</label>
            <select name="rooms" required>
                <option value="1">1 комната</option>
                <option value="2">2 комнаты</option>
                <option value="3">3 комнаты</option>
                <option value="4">4+ комнаты</option>
            </select>
        </div>

        <div class="form-group">
            <label>Площадь (м²)</label>
            <input type="number" step="0.1" name="area" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Цена (₽)</label>
            <input type="number" name="price" required>
        </div>

        <div class="form-group">
            <label>Этаж</label>
            <input type="number" name="floor" required>
        </div>
    </div>

    <div class="form-group">
        <label>Статус</label>
        <select name="status" required>
            <option value="available">Доступна</option>
            <option value="sold">Продана</option>
            <option value="booked">Забронирована</option>
        </select>
    </div>

    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="{{ route('admin.flats.index') }}" class="btn">Отмена</a>
</form>
@endsection