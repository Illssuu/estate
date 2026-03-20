@extends('layouts.app')

@section('title', 'Мои записи на просмотр')
@section('content')
<div class="profile-page">
    <div class="container">
        <div class="profile-header mb-4">
            <h1 class="h2 mb-2">Мои записи на просмотр</h1>
            <p>Все ваши записи на просмотр квартир</p>
        </div>

        @if($appointments->count() > 0)
            <div class="appointments-list">
                @foreach($appointments as $appointment)
                    @if($appointment->status == 'active')
                    <div class="appointment-item" data-id="{{ $appointment->id }}">
                        <div class="appointment-info">
                            <div class="appointment-date">
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d.m.Y') }} в {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                            </div>
                            <div class="appointment-flat">
                                <strong>Квартира:</strong> 
                                <a href="{{ route('flats.show', $appointment->flat_id) }}" class="flat-link">
                                    {{ $appointment->flat->title }}
                                </a>
                            </div>
                            @if($appointment->comment)
                                <div class="appointment-comment">«{{ $appointment->comment }}»</div>
                            @endif
                        </div>
                        <div class="appointment-status">
                            <span class="status status-active">Активна</span>
                            <button class="btn-cancel" onclick="cancelAppointment(this, {{ $appointment->id }})">Отменить</button>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            {{ $appointments->links() }}
        @else
            <div class="empty-state">
                <p>У вас пока нет активных записей на просмотр</p>
                <a href="{{ route('flats.index') }}" class="btn btn-primary">Выбрать квартиру</a>
            </div>
        @endif
    </div>
</div>

<style>
.appointments-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.appointment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.appointment-date {
    font-size: 16px;
    font-weight: 600;
    color: #1a3b2e;
    margin-bottom: 8px;
}

.appointment-flat {
    font-size: 14px;
    color: #333;
}

.flat-link {
    color: #1a3b2e;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.flat-link:hover {
    color: #7b5141;
    text-decoration: underline;
}

.appointment-comment {
    font-size: 13px;
    color: #666;
    margin-top: 5px;
    font-style: italic;
}

.status {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.status-active {
    background: #d1e7dd;
    color: #0f5132;
}

.btn-cancel {
    display: inline-block;
    margin-left: 10px;
    padding: 5px 12px;
    border: 1px solid #dc3545;
    border-radius: 20px;
    background: white;
    color: #dc3545;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #dc3545;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 10px;
}

.btn-primary {
    background: #1a3b2e;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    display: inline-block;
}

@media (max-width: 768px) {
    .appointment-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
}
</style>

<script>
function cancelAppointment(btn, id) {
    btn.disabled = true;
    btn.textContent = '...';
    
    fetch(`/appointments/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Удаляем элемент из DOM
            const item = btn.closest('.appointment-item');
            item.style.opacity = '0';
            setTimeout(() => {
                item.remove();
                // Если больше нет записей, показываем пустое состояние
                const remainingItems = document.querySelectorAll('.appointment-item').length;
                if (remainingItems === 0) {
                    location.reload();
                }
            }, 300);
        } else {
            btn.disabled = false;
            btn.textContent = 'Отменить';
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        btn.disabled = false;
        btn.textContent = 'Отменить';
    });
}
</script>
@endsection