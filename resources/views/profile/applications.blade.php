@extends('layouts.app')

@section('title', 'Мои заявки')
@section('content')
<div class="applications-page">
    <div class="container">
        <div class="applications-title">
        <h1>Мои заявки</h1>
        <button class="btn btn-primary" onclick="openModal()"> + Новая завка</button>
    </div>

    <div class="filter-tabs">
        <a href="{{ route('profile.applications') }}" class="filter-tab {{  !request('status') ? 'active' : ''}}">Все</a>
        <a href="{{ route('profile.applications', ['status' => 'new']) }}" class="'filter-tab {{ request('status') == 'new' ? 'active' : '' }}">Новые</a>
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
                        @if($application->type == 'call')
                            Заявка на звонок
                        @else 
                            Запись на просмотр
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

                    @if($application->viewing_date)
                        <div class="detail-row">
                            <span class="detail-label">Дата просмотра:</span>
                            <span class="detail-value">{{ $application->viewing_date->format('d.m.Y H:i') }}</span>
                        </div>
                    @endif

                    @if($application->comment)
                        <div class="detail-row">
                            <span class="detail-label">Комментарий:</span>
                            <span class="detail-value">«{{ $application->comment }}»</span>
                        </div>
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
        <p>Оставьте заявку на звонок или запишитесь на просмотр квартиры</p>
        <button class="btn btn-primary" onclick="openModal()">
            Создать заявку
        </button>
    </div>
@endif

<!-- Модальное окно для новой заявки -->
<div id="applicationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Новая заявка</h3>
            <button type="button" class="modal-close" onclick="closeModal()">×</button>
        </div>
        
        <form action="{{ route('profile.applications.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Тип заявки</label>
                    <select name="type" class="form-control" required onchange="toggleViewingDate(this)">
                        <option value="call">Заказать звонок</option>
                        <option value="viewing">Записаться на просмотр</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Квартира (необязательно)</label>
                    <select name="flat_id" class="form-control">
                        <option value="">Не выбрана</option>
                        @foreach(\App\Models\Flat::all() as $flat)
                            <option value="{{ $flat->id }}">{{ $flat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group viewing-date-field" style="display: none;">
                    <label class="form-label">Дата и время просмотра</label>
                    <input type="datetime-local" name="viewing_date" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Комментарий</label>
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


function toggleViewingDate(select) {
    const viewingField = document.querySelector('.viewing-date-field');
    viewingField.style.display = select.value === 'viewing' ? 'block' : 'none';
}
</script>