@extends('layouts.app')

@section('title', 'Личный кабинет')
@section('content')
<div class="profile-page">
    <div class="container">

        <div class="profile-header mb-4">
            <h1 class="h2 mb-2">Здравствуйте, {{ auth()->user()->name }}!</h1>
            <p>Рады видеть вас снова. Здесь вы можете управлять своими заявками и избранным.</p>
        </div>

        <!-- Статистика -->
        <div class="stats-grid mb-5">
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-number">{{ $favoritesCount }}</span>
                    <span class="stat-label">в избранном</span>
                </div>
                <a href="{{ route('profile.favorites') }}" class="stat-link">Перейти →</a>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-number">{{ $applicationCount }}</span>
                    <span class="stat-label">заявок</span>
                </div>
                <a href="{{ route('profile.applications') }}" class="stat-link">Перейти →</a>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-number">Настройки</span>
                    <span class="stat-label">профиля</span>
                </div>
                <a href="{{ route('profile.settings') }}" class="stat-link">Перейти →</a>
            </div>
        </div>

        <!-- Последние заявки -->
        <div class="recent-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4">Последние заявки</h2>
                <a href="{{ route('profile.applications') }}" class="btn btn-outline-primary btn-sm">Все заявки</a>
            </div>

            @if($recentApplications->count() > 0)
                <div class="applications-list">
                    @foreach($recentApplications as $application)
                        <div class="application-item">
                            <div class="application-info">
                                <div class="application-type">
                                    <span class="application-date">{{ $application->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="application-details">
                                    @if(isset($application->contract_number)) <!-- Это заявка на возврат -->
                                        <strong>Запрос на выкуп:</strong> договор №{{ $application->contract_number }}
                                        
                                    @elseif($application->flat) <!-- Обычная заявка на квартиру -->
                                        <strong>Квартира:</strong> {{ $application->flat->title }}
                                        @if($application->viewing_date)
                                            <div><strong>На просмотр:</strong> {{ $application->viewing_date->format('d.m.Y H:i') }}</div>
                                        @endif
                                    @else <!-- Просто звонок -->
                                        <strong>Звонок</strong>
                                    @endif
                                    
                                    @if($application->comment)
                                        <div class="text-muted small">«{{ $application->comment }}»</div>
                                    @endif
                                </div>
                            </div>
                     <div class="application-status">
    @switch($application->status)
        @case('new')
            <span class="status status-new">Новая</span>
            @break
        @case('processed')
            <span class="status status-processed">Обработана</span>
            @break
        @case('called')
            <span class="status status-called">Перезвонили</span>
            @break
        @default
            <span class="status status-new">{{ $application->status }}</span>
    @endswitch
</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <p>У вас пока нет заявок</p>
                    <a href="{{ route('flats.index') }}" class="btn btn-primary">Выбрать квартиру</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Все ваши стили остаются без изменений */
.profile-page {
    padding: 40px 0 60px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 40px;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 12px;
}

.stat-content {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
}

.stat-link {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 25px;
    color: #2c3e50;
    text-decoration: none;
    opacity: 0;
    transition: opacity 0.3s;
    font-weight: 500;
}

.stat-card:hover .stat-link {
    opacity: 1;
}

.recent-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.applications-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.application-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    transition: background 0.3s;
}

.application-item:hover {
    background: #f0f0f0;
}

.application-info {
    flex: 1;
}

.application-type {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 8px;
}

.application-date {
    font-size: 13px;
    color: #6c757d;
}

.application-details {
    font-size: 14px;
}

.application-details strong {
    color: #2c3e50;
    margin-right: 5px;
}

.application-status {
    min-width: 120px;
    text-align: right;
}

.status {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.status-new {
    background: #cfe2ff;
    color: #0a58ca;
}

.status-processed {
    background: #fff3cd;
    color: #997404;
}

.status-called {
    background: #d1e7dd;
    color: #0f5132;
}

/* Новые статусы для заявок на возврат */
.status-pending {
    background: #fff3cd;
    color: #997404;
}

.status-verified {
    background: #d1e7dd;
    color: #0f5132;
}

.status-rejected {
    background: #f8d7da;
    color: #842029;
}

.status-completed {
    background: #cfe2ff;
    color: #0a58ca;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 20px;
    font-size: 16px;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .application-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .application-status {
        text-align: left;
        width: 100%;
    }
}
</style>
@endsection