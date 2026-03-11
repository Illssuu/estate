@extends('layouts.app')

@section('title', 'Личный кабинет')
@section('content')
<div class="profile-page">
    <div class="container">

        <div class="profile-header">
            <h1>Здравствуйте, {{ auth()->user()->name }}!</h1>
            <p>Рады видеть вас снова. Здесь вы можете управлять своими заявками и избранным.</p>
        </div>

        <!-- Статистика -->
        <div class="stats-grid">
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
                    <span class="stat-number">⚙️</span>
                    <span class="stat-label">Настройки профиля</span>
                </div>
                <a href="{{ route('profile.settings') }}" class="stat-link">Перейти →</a>
            </div>
        </div>

        <!-- Последние заявки -->
        <div class="recent-section">
            <div class="section-header">
                <h2>Последние заявки</h2>
                <a href="{{ route('profile.applications') }}" class="btn btn-outline">Все заявки</a>
            </div>

            @if($recentApplications->count() > 0)
                <div class="applications-list">
                    @foreach($recentApplications as $application)
                        <div class="application-item">
                            <div class="application-info">
                                <div class="application-type">
                                    @if($application->type == 'call')
                                        <span class="badge badge-call">📞 Заявка на звонок</span>
                                    @else
                                        <span class="badge badge-viewing">👁️ Запись на просмотр</span>
                                    @endif
                                    <span class="application-date">{{ $application->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                
                                @if($application->flat)
                                    <div class="application-detail">
                                        <span class="detail-label">Квартира:</span>
                                        <span class="detail-value">{{ $application->flat->title }}</span>
                                    </div>
                                @endif
                                
                                @if($application->viewing_date)
                                    <div class="application-detail">
                                        <span class="detail-label">На просмотр:</span>
                                        <span class="detail-value">{{ $application->viewing_date->format('d.m.Y H:i') }}</span>
                                    </div>
                                @endif
                                
                                @if($application->comment)
                                    <div class="application-comment">«{{ $application->comment }}»</div>
                                @endif
                            </div>
                            
                            <div class="application-status">
                                @switch($application->status)
                                    @case('new')
                                        <span class="status status-new">Новая</span>
                                        @break
                                    @case('processed')
                                        <span class="status status-processed">В обработке</span>
                                        @break
                                    @case('called')
                                        <span class="status status-called">Перезвонили</span>
                                        @break
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
.profile-page {
    padding: 40px 0 60px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Заголовок профиля */
.profile-header {
    margin-bottom: 40px;
}

.profile-header h1 {
    font-size: 28px;
    font-weight: 500;
    color: #333;
    margin: 0 0 10px;
}

.profile-header p {
    font-size: 16px;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

/* Сетка статистики */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: relative;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.stat-content {
    text-align: left;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 5px;
}

.stat-label {
    color: #999;
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
    font-size: 14px;
}

.stat-card:hover .stat-link {
    opacity: 1;
}

/* Секция с заявками */
.recent-section {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.section-header h2 {
    font-size: 20px;
    font-weight: 500;
    color: #333;
    margin: 0;
}

/* Кнопки */
.btn {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: #2c3e50;
    color: white;
}

.btn-primary:hover {
    background: #1e2b37;
}

.btn-outline {
    background: transparent;
    color: #2c3e50;
    border: 1px solid #2c3e50;
}

.btn-outline:hover {
    background: #2c3e50;
    color: white;
}

.btn-sm {
    padding: 5px 12px;
    font-size: 13px;
}

/* Список заявок */
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
    border-radius: 8px;
    transition: background 0.2s;
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
    margin-bottom: 10px;
    flex-wrap: wrap;
}

/* Бейджи */
.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge-call {
    background: #e3f2fd;
    color: #1976d2;
}

.badge-viewing {
    background: #e8f5e8;
    color: #2e7d32;
}

.application-date {
    font-size: 13px;
    color: #999;
}

.application-detail {
    font-size: 14px;
    margin-bottom: 5px;
}

.detail-label {
    color: #666;
    margin-right: 8px;
}

.detail-value {
    color: #333;
}

.application-comment {
    font-size: 13px;
    color: #666;
    font-style: italic;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px dashed #ddd;
}

/* Статусы заявок */
.application-status {
    min-width: 120px;
    text-align: right;
}

.status {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-new {
    background: #e3f2fd;
    color: #1976d2;
}

.status-processed {
    background: #fff3e0;
    color: #f57c00;
}

.status-called {
    background: #e8f5e8;
    color: #2e7d32;
}

/* Пустое состояние */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.empty-state p {
    color: #999;
    margin-bottom: 20px;
    font-size: 16px;
}

/* Адаптивность */
@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
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
    
    .section-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .application-type {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}

@media (max-width: 480px) {
    .profile-header h1 {
        font-size: 24px;
    }
    
    .recent-section {
        padding: 20px;
    }
    
    .stat-card {
        padding: 20px;
    }
    
    .stat-number {
        font-size: 28px;
    }
}
</style>
@endsection