@extends('layouts.admin')

@section('title', 'Редактирование квартиры')
@section('header', 'Редактировать квартиру')

@section('content')
<div style="max-width: 800px;">
    <form action="{{ route('admin.flats.update', $flat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Основная информация -->
        <div class="form-card">
            <h3>Основная информация</h3>
            
            <div class="form-group">
                <label>Название квартиры *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $flat->title) }}" required>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $flat->description) }}</textarea>
            </div>
        </div>

        <!-- Цена и площадь -->
        <div class="form-card">
            <h3>Цена и площадь</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Цена (₽) *</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $flat->price) }}" required>
                </div>

                <div class="form-group">
                    <label>Общая площадь (м²) *</label>
                    <input type="number" name="area" class="form-control" step="0.01" value="{{ old('area', $flat->area) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Жилая площадь (м²)</label>
                    <input type="number" name="living_area" class="form-control" step="0.01" value="{{ old('living_area', $flat->living_area) }}">
                </div>
            </div>
        </div>

        <!-- Характеристики -->
        <div class="form-card">
            <h3>Характеристики</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Количество комнат *</label>
                    <select name="rooms" class="form-control" required>
                        <option value="1" {{ old('rooms', $flat->rooms) == 1 ? 'selected' : '' }}>1 комната</option>
                        <option value="2" {{ old('rooms', $flat->rooms) == 2 ? 'selected' : '' }}>2 комнаты</option>
                        <option value="3" {{ old('rooms', $flat->rooms) == 3 ? 'selected' : '' }}>3 комнаты</option>
                        <option value="4" {{ old('rooms', $flat->rooms) == 4 ? 'selected' : '' }}>4+ комнаты</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Этаж *</label>
                    <input type="number" name="floor" class="form-control" value="{{ old('floor', $flat->floor) }}" required>
                </div>

                <div class="form-group">
                    <label>Всего этажей *</label>
                    <input type="number" name="total_floors" class="form-control" value="{{ old('total_floors', $flat->total_floors) }}" required>
                </div>
            </div>
        </div>

        <!-- Тип и отделка -->
        <div class="form-card">
            <h3>Тип и отделка</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Тип жилья</label>
                    <select name="housing_type" class="form-control">
                        <option value="new_building" {{ old('housing_type', $flat->housing_type) == 'new_building' ? 'selected' : '' }}>Новостройка</option>
                        <option value="secondary" {{ old('housing_type', $flat->housing_type) == 'secondary' ? 'selected' : '' }}>Вторичка</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Отделка</label>
                    <select name="finishing" class="form-control">
                        <option value="rough" {{ old('finishing', $flat->finishing) == 'rough' ? 'selected' : '' }}>Черновая</option>
                        <option value="fine" {{ old('finishing', $flat->finishing) == 'fine' ? 'selected' : '' }}>Чистовая</option>
                        <option value="euro" {{ old('finishing', $flat->finishing) == 'euro' ? 'selected' : '' }}>Евроремонт</option>
                        <option value="without" {{ old('finishing', $flat->finishing) == 'without' ? 'selected' : '' }}>Без отделки</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Вид из окна</label>
                    <select name="view_type" class="form-control">
                        <option value="yard" {{ old('view_type', $flat->view_type) == 'yard' ? 'selected' : '' }}>Во двор</option>
                        <option value="street" {{ old('view_type', $flat->view_type) == 'street' ? 'selected' : '' }}>На улицу</option>
                        <option value="combined" {{ old('view_type', $flat->view_type) == 'combined' ? 'selected' : '' }}>Комбинированный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Санузел</label>
                    <select name="bathroom" class="form-control">
                        <option value="separate" {{ old('bathroom', $flat->bathroom) == 'separate' ? 'selected' : '' }}>Раздельный</option>
                        <option value="combined" {{ old('bathroom', $flat->bathroom) == 'combined' ? 'selected' : '' }}>Совмещенный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Балкон</label>
                    <select name="balcony" class="form-control">
                        <option value="1" {{ old('balcony', $flat->balcony) == 1 ? 'selected' : '' }}>Есть</option>
                        <option value="0" {{ old('balcony', $flat->balcony) == 0 ? 'selected' : '' }}>Нет</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Статус -->
        <div class="form-card">
            <h3>Статус</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Статус продажи</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ old('status', $flat->status) == 'available' ? 'selected' : '' }}>Доступна</option>
                        <option value="reserved" {{ old('status', $flat->status) == 'reserved' ? 'selected' : '' }}>Забронирована</option>
                        <option value="sold" {{ old('status', $flat->status) == 'sold' ? 'selected' : '' }}>Продана</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Доступность</label>
                    <select name="is_available" class="form-control">
                        <option value="1" {{ old('is_available', $flat->is_available) == 1 ? 'selected' : '' }}>Доступна</option>
                        <option value="0" {{ old('is_available', $flat->is_available) == 0 ? 'selected' : '' }}>Не доступна</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Кнопки -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Обновить квартиру</button>
            <a href="{{ route('admin.flats.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection