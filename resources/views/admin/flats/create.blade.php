@extends('layouts.admin')

@section('title', 'Добавление квартиры')
@section('header', 'Добавить новую квартиру')

@section('content')
<div style="max-width: 80%; margin: 0 auto">
    <form action="{{ route('admin.flats.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Основная информация -->
        <div class="form-card">
            <h3>Основная информация</h3>
            
            <div class="form-group">
                <label>Название квартиры *</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
        </div>

        <!-- Цена и площадь -->
        <div class="form-card">
            <h3>Цена и площадь</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Цена (₽) *</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Общая площадь (м²) *</label>
                    <input type="number" name="area" class="form-control" step="0.01" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Жилая площадь (м²)</label>
                    <input type="number" name="living_area" class="form-control" step="0.01">
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
                        <option value="1">1 комната</option>
                        <option value="2">2 комнаты</option>
                        <option value="3">3 комнаты</option>
                        <option value="4">4+ комнаты</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Этаж *</label>
                    <input type="number" name="floor" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Всего этажей *</label>
                    <input type="number" name="total_floors" class="form-control" required>
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
                        <option value="new_building">Новостройка</option>
                        <option value="secondary">Вторичка</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Отделка</label>
                    <select name="finishing" class="form-control">
                        <option value="rough">Черновая</option>
                        <option value="fine">Чистовая</option>
                        <option value="euro">Евроремонт</option>
                        <option value="without">Без отделки</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Вид из окна</label>
                    <select name="view_type" class="form-control">
                        <option value="yard">Во двор</option>
                        <option value="street">На улицу</option>
                        <option value="combined">Комбинированный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Санузел</label>
                    <select name="bathroom" class="form-control">
                        <option value="separate">Раздельный</option>
                        <option value="combined">Совмещенный</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Балкон</label>
                    <select name="balcony" class="form-control">
                        <option value="1">Есть</option>
                        <option value="0">Нет</option>
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
                        <option value="available">Доступна</option>
                        <option value="reserved">Забронирована</option>
                        <option value="sold">Продана</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Доступность</label>
                    <select name="is_available" class="form-control">
                        <option value="1">Доступна</option>
                        <option value="0">Не доступна</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-card">
            <h3>Фотографии квартиры</h3>
            <div class="form-group">
                <label>Загрузить фото</label>
                <input type="file" name="photos[]" multiple accept="image/*" class="form-control">
                <small class="text-muted">Можно выбрать несколько фото</small>
            </div>
        </div>
        <!-- Кнопки -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить квартиру</button>
            <a href="{{ route('admin.flats.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection