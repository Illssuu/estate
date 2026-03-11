@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Заявки на звонок</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Квартира</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ $request->name }}</td>
                <td>{{ $request->phone }}</td>
                <td>
                    <a href="{{ route('admin.flats.show', $request->flat_id) }}">
                        {{ $request->flat_title }}
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.call-requests.update', $request) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()">
                            <option value="new" {{ $request->status == 'new' ? 'selected' : '' }}>Новая</option>
                            <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>В обработке</option>
                            <option value="processed" {{ $request->status == 'processed' ? 'selected' : '' }}>Позвонили</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.call-requests.show', $request) }}" class="btn btn-sm btn-info">Просмотр</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $requests->links() }}
</div>
@endsection