@extends('layouts.admin')

@section('title', 'Просмотр заявки на выкуп')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        
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
                            <td>{{ $buyback->id }}</td>
                        </tr>
                        <tr>
                            <th>Тип заявки:</th>
                            <td>
                                <span class="badge bg-warning text-dark">Выкуп</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Статус:</th>
                            <td>
                                <form action="{{ route('admin.buyback.status', $buyback->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                                        <option value="pending" {{ $buyback->status == 'pending' ? 'selected' : '' }}>На проверке</option>
                                        <option value="verified" {{ $buyback->status == 'verified' ? 'selected' : '' }}>Одобрено</option>
                                        <option value="rejected" {{ $buyback->status == 'rejected' ? 'selected' : '' }}>Отклонено</option>
                                        <option value="completed" {{ $buyback->status == 'completed' ? 'selected' : '' }}>Завершено</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Дата создания:</th>
                            <td>{{ $buyback->created_at->format('d.m.Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Последнее обновление:</th>
                            <td>{{ $buyback->updated_at->format('d.m.Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Данные договора</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Номер договора:</th>
                            <td><strong>{{ $buyback->contract_number }}</strong></td>
                        </tr>
                        <tr>
                            <th>Дата договора:</th>
                            <td>{{ \Carbon\Carbon::parse($buyback->contract_date)->format('d.m.Y') }}</td>
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
                            <th style="width: 150px;">ФИО:</th>
                            <td>{{ $buyback->name }}</td>
                        </tr>
                        <tr>
                            <th>Телефон:</th>
                            <td>{{ $buyback->phone }}</td>
                        </tr>
                        @if($buyback->user)
                        <tr>
                            <th>Пользователь:</th>
                            <td>
                                {{ $buyback->user->name }} (ID: {{ $buyback->user->id }})<br>
                                <small class="text-muted">Email: {{ $buyback->user->email }}</small>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        
        @if($buyback->contract_scan_images)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Скан договора</h5>
                </div>
                <div class="card-body">
                    @php
                        $images = json_decode($buyback->contract_scan_images, true);
                    @endphp
                    
                    @if(is_array($images) && count($images) > 0)
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-3 mb-3">
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="d-block">
                                        <div class="scan-preview">
                                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid" alt="Скан договора">
                                            <div class="scan-overlay">
                                                <i class="bi bi-eye"></i> Увеличить
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Нет сканов договора</p>
                    @endif
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
    border-radius: 4px;
}
.form-select-sm {
    padding: 4px 8px;
    font-size: 13px;
    border-radius: 4px;
    border: 1px solid #ddd;
}
.form-select-sm:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Стили для превью сканов */
.scan-preview {
    position: relative;
     width: 200px; /* Берет ширину от колонки col-md-3 */
    height: 200px; /* Фиксированная высота для всех превью */
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1/1.4;
    background: #f8f9fa;
}

.scan-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.scan-preview:hover img {
    transform: scale(1.05);
}

.scan-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 8px;
    text-align: center;
    font-size: 13px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.scan-preview:hover .scan-overlay {
    opacity: 1;
}

.scan-overlay i {
    margin-right: 5px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    padding: 15px 20px;
    border-radius: 8px;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}
</style>
@endsection