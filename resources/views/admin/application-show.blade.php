@extends('layouts.admin')

@section('title', 'Просмотр заявки')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Просмотр заявки #{{ $application->id }}</h1>
        <a href="{{ route('admin.applications') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Назад к списку
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Успешно!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Информация о заявке</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">ID заявки:</th>
                            <td>{{ $application->id }}</td>
                        </tr>
                        <tr>
                            <th>Тип заявки:</th>
                            <td>
                                <span class="badge bg-info text-dark">Звонок</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td>
                                <form action="{{ route('admin.application.status', $application->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                                        <option value="new" {{ $application->status == 'new' ? 'selected' : '' }}>Новая</option>
                                        <option value="processed" {{ $application->status == 'processed' ? 'selected' : '' }}>Обработана</option>
                                        <option value="called" {{ $application->status == 'called' ? 'selected' : '' }}>Перезвонили</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Дата создания:</th>
                            <td>{{ $application->created_at->format('d.m.Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Последнее обновление:</th>
                            <td>{{ $application->updated_at->format('d.m.Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Контактные данные</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Имя:</th>
                            <td>{{ $application->name }}</td>
                        </tr>
                        <tr>
                            <th>Телефон:</th>
                            <td>{{ $application->phone }}</td>
                        </tr>
                        @if($application->user)
                        <tr>
                            <th>Пользователь:</th>
                            <td>
                                {{ $application->user->name }} (ID: {{ $application->user->id }})<br>
                                <small class="text-muted">Email: {{ $application->user->email }}</small>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        
        @if($application->flat)
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Информация о квартире</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 150px;">Название:</th>
                                    <td>{{ $application->flat->title }}</td>
                                </tr>
                                <tr>
                                    <th>Адрес:</th>
                                    <td>{{ $application->flat->address ?? 'Не указан' }}</td>
                                </tr>
                                <tr>
                                    <th>Комнат:</th>
                                    <td>{{ $application->flat->rooms }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 150px;">Площадь:</th>
                                    <td>{{ $application->flat->area }} м²</td>
                                </tr>
                                <tr>
                                    <th>Цена:</th>
                                    <td>{{ number_format($application->flat->price, 0, ',', ' ') }} ₽</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>
                                        <a href="{{ route('flats.show', $application->flat->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                            Перейти к квартире
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @if($application->comment)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Комментарий</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $application->comment }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.table-borderless tr {
    border-bottom: 1px solid #f0f0f0;
}
.table-borderless tr:last-child {
    border-bottom: none;
}
.table-borderless th {
    font-weight: 600;
    color: #555;
    background-color: transparent;
}
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}
.card-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #333;
}
.badge {
    padding: 6px 12px;
    font-weight: 500;
}
.form-select-sm {
    padding: 4px 8px;
    font-size: 13px;
    border-radius: 4px;
    border: 1px solid #ddd;
}
</style>
@endsection