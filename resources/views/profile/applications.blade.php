@extends('layouts.app')

@section('title', 'Мои заявки')
@section('content')
<div class="applications-page">
    <div class="container">
        <div class="applications-title">
            <h1>Мои заявки</h1>
            <button class="btn btn-primary" onclick="openModal()"> + Новая заявка</button>
        </div>

        <div class="filter-tabs">
            <a href="{{ route('profile.applications') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">Все</a>
            <a href="{{ route('profile.applications', ['status' => 'new']) }}" class="filter-tab {{ request('status') == 'new' ? 'active' : '' }}">Новые</a>
            <a href="{{ route('profile.applications', ['status' => 'processed']) }}" class="filter-tab {{ request('status') == 'processed' ? 'active' : '' }}">В обработке</a>
            <a href="{{ route('profile.applications', ['status' => 'called']) }}" class="filter-tab {{ request('status') == 'called' ? 'active' : '' }}">Завершенные</a>
        </div>

        @if($applications->count() > 0)
   
            <div class="applications-timeline">
                @foreach($applications as $application)

                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <h3 class="timeline-title">
                                @if(isset($application->contract_number))
                                    Запрос на обратный выкуп
                                @else
                                    Заявка на звонок
                                @endif
                            </h3>
                            <span class="timeline-date">{{ $application->created_at->format('d.m.Y H:i') }}</span>
                        </div>

                        <div class="timeline-status">
                            @switch($application->status)
                                @case('new')
                                    <span class="status status-new">Новая заявка</span>
                                    @break
                                @case('processed')
                                    <span class="status status-processed">Обработана</span>
                                    @break
                                @case('called')
                                    <span class="status status-called">Перезвонили</span>
                                    @break
                            @endswitch
                        </div>

                        <div class="timeline-details">
                            @if(isset($application->contract_number))
                                <!-- Заявка на возврат -->
                                <div class="detail-row">
                                    <span class="detail-label">Договор:</span>
                                    <span class="detail-value">№{{ $application->contract_number }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Дата договора:</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($application->contract_date)->format('d.m.Y') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">ФИО:</span>
                                    <span class="detail-value">{{ $application->name }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Телефон:</span>
                                    <span class="detail-value">{{ $application->phone }}</span>
                                </div>
                            @else
                                <!-- Обычная заявка -->
                                <div class="detail-row">
                                    <span class="detail-label">Имя:</span>
                                    <span class="detail-value">{{ $application->name }}</span>
                                </div>

                                <div class="detail-row">
                                    <span class="detail-label">Телефон:</span>
                                    <span class="detail-value">{{ $application->phone }}</span>
                                </div>

                                @if($application->flat)
                                    <div class="detail-row">
                                        <span class="detail-label">Квартира:</span>
                                        <span class="detail-value">
                                            <a href="{{ route('flats.show', $application->flat->id) }}">
                                                {{ $application->flat->title }}
                                            </a>
                                        </span>
                                    </div>
                                @endif

                                @if($application->comment)
                                    <div class="detail-row">
                                        <span class="detail-label">Комментарий:</span>
                                        <span class="detail-value">«{{ $application->comment }}»</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pagination-wrapper mt-5">
                {{ $applications->withQueryString()->links() }}
            </div>
        @else
            <div class="empty-state">
                <h3>У вас пока нет заявок</h3>
                <p>Оставьте заявку на звонок по квартире</p>
                <button class="btn btn-primary" onclick="openModal()">
                    Создать заявку
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Модальное окно для новой заявки (только звонок) -->
<div id="applicationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Новая заявка на звонок</h3>
            <button type="button" class="modal-close" onclick="closeModal()">×</button>
        </div>
        
        <form action="{{ route('applications.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="flat_id" value="0">
                <div class="form-group">
                    <label class="form-label">Ваше имя</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Номер телефона</label>
                    <input type="tel" name="phone" class="form-control" placeholder="+7 (___) ___-__-__" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Комментарий (необязательно)</label>
                    <textarea name="comment" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Отмена</button>
                <button type="submit" class="btn btn-primary">Отправить заявку</button>
            </div>
        </form>
    </div>
</div>

<style>
    .applications-page {
        padding: 40px 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f5f5f5;
        min-height: 100vh;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .applications-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .applications-title h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
        font-weight: 500;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-primary {
        background: #2c3e50;
        color: white;
           display: none;
    }

    .btn-primary:hover {
        background: #1e2b37;
    }

    .btn-secondary {
        background: #e0e0e0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #d0d0d0;
    }

    .filter-tabs {
        display: none;
        gap: 10px;
        margin-bottom: 25px;
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 20px;
        border-radius: 20px;
        text-decoration: none;
        color: #666;
        background: #f5f5f5;
        transition: all 0.2s;
        font-size: 14px;
    }

    .filter-tab:hover {
        background: #e0e0e0;
    }

    .filter-tab.active {
        background: #2c3e50;
        color: white;
    }

    .applications-timeline {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .timeline-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .timeline-title {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .timeline-date {
        font-size: 13px;
        color: #999;
    }

    .timeline-status {
        margin-bottom: 15px;
    }

    .status {
        display: inline-block;
        padding: 4px 12px;
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

    .timeline-details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .detail-row:last-child {
        margin-bottom: 0;
    }

    .detail-label {
        min-width: 100px;
        color: #666;
    }

    .detail-value {
        color: #333;
    }

    .detail-value a {
        color: #2c3e50;
        text-decoration: none;
    }

    .detail-value a:hover {
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .empty-state h3 {
        margin: 0 0 10px;
        font-size: 18px;
        color: #333;
        font-weight: 500;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #999;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 500;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        padding: 0;
        line-height: 1;
    }

    .modal-close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #2c3e50;
    }

    @media (max-width: 600px) {
        .applications-title {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .filter-tabs {
            justify-content: center;
        }
        
        .timeline-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .detail-row {
            flex-direction: column;
            gap: 5px;
        }
        
        .detail-label {
            min-width: auto;
        }
        
        .modal-footer {
            flex-direction: column;
        }
        
        .modal-footer .btn {
            width: 100%;
        }
    }
</style>

<script>
function openModal() {
    document.getElementById('applicationModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('applicationModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('applicationModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

@endsection