@extends('layouts.admin')

@section('title', 'Управление пользователями')
@section('header', 'Пользователи')

@section('content')
<div class="actions-bar">
    <div class="actions-left">
        <span class="users-count">Всего: {{ $users->total() }}</span>
    </div>
    
    <!-- Поиск -->
    <form method="GET" action="{{ route('admin.users') }}" class="search-form">
        <input type="text" 
               name="search" 
               placeholder="Поиск по имени или email..." 
               value="{{ request('search') }}"
               class="search-input">
        <button type="submit" class="search-btn">Найти</button>
        @if(request('search'))
            <a href="{{ route('admin.users') }}" class="search-clear">✕</a>
        @endif
    </form>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Логин</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Роль</th>
                <th>Дата</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->login }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '—' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="role-form">
                        @csrf
                        <select name="role" onchange="this.form.submit()" class="role-select">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                        </select>
                    </form>
                </td>
                <td>{{ $user->created_at->format('d.m.Y') }}</td>
              
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $users->withQueryString()->links() }}
</div>

<style>
.actions-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}



.search-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    width: 250px;
    font-size: 14px;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-dark);
}

.search-btn {
    padding: 8px 16px;
    background: var(--primary-dark);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.search-clear {
    padding: 5px 8px;
    color: #999;
    text-decoration: none;
    font-size: 16px;
}

.search-clear:hover {
    color: #d32f2f;
}



.role-select {
    padding: 4px 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
    background: white;
    cursor: pointer;
}

.role-select:hover {
    border-color: var(--primary-dark);
}

.role-form {
    margin: 0;
}




</style>
@endsection