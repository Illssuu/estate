@extends('layouts.admin')

@section('title', 'Управление заявками')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Все заявки</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Успешно!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            @if($applications->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Тип</th>
                            <th>Пользователь</th>
                            <th>Телефон</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>{{ $app->id }}</td>
                            <td>
                                @if(isset($app->contract_number))
                                    <span class="badge bg-warning text-dark">Выкуп</span>
                                @else
                                    <span class="badge bg-info text-dark">Звонок</span>
                                @endif
                            </td>
                            <td>{{ $app->user->name ?? $app->name }}</td>
                            <td>{{ $app->phone }}</td>
                            <td>
                                <form action="{{ route(isset($app->contract_number) ? 'admin.buyback.status' : 'admin.application.status', $app->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" style="width: 140px;" onchange="this.form.submit()">
                                       
                                            <option value="new" {{ $app->status == 'new' ? 'selected' : '' }}>Новая</option>
                                            <option value="processed" {{ $app->status == 'processed' ? 'selected' : '' }}>Обработана</option>
                                            <option value="called" {{ $app->status == 'called' ? 'selected' : '' }}>Перезвонили</option>

                                    </select>
                                </form>
                            </td>
                            <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route(isset($app->contract_number) ? 'admin.buyback.show' : 'admin.application.show', $app->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Просмотр
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Заявок пока нет
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 8px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
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
    border-color: #80ffbd;
    outline: 0;
}

.btn-sm {
    padding: 4px 12px;
    font-size: 13px;
}


</style>
@endsection