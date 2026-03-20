@extends('layouts.admin')

@section('title', 'Календарь просмотров')
@section('content')
<div class="admin-calendar">
    <div class="container">
        <div class="calendar-header">
            <h1 class="h2">Календарь просмотров</h1>
            <p>Занятые слоты на выбранную дату</p>
        </div>

        <!-- Выбор даты -->
        <div class="date-selector">
            <form method="GET" action="{{ route('admin.calendar') }}" class="date-form">
                <label for="date">Выберите дату:</label>
                <input type="date" 
                       id="date" 
                       name="date" 
                       value="{{ $date }}" 
                       min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                       onchange="this.form.submit()">
            </form>
        </div>

        <!-- Календарь слотов -->
        <div class="slots-grid">
            @foreach($allSlots as $time => $slot)
                <div class="slot-card {{ $slot ? 'occupied' : 'free' }}">
                    <div class="slot-time">{{ $time }}</div>
                    
                    @if($slot)
                        <div class="slot-info">
                            <div class="slot-name">{{ $slot['name'] }}</div>
                            <div class="slot-flat">
                                <a href="{{ route('flats.show', $slot['flat_id']) }}" target="_blank">
                                    {{ $slot['flat_title'] }}
                                </a>
                            </div>
                            @if($slot['phone'] && $slot['phone'] != 'не указан')
                                <div class="slot-phone">{{ $slot['phone'] }}</div>
                            @endif
                        </div>
                    @else
                        <div class="slot-free">—</div>
                    @endif
                </div>
            @endforeach
        </div>

        @if(empty(array_filter($allSlots)))
            <div class="empty-state">
                <p>На эту дату нет записей</p>
            </div>
        @endif
    </div>
</div>

<style>
.admin-calendar {
    padding: 30px 0;
    background: #f5f5f5;
    min-height: 100vh;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 15px;
}

.calendar-header {
    margin-bottom: 25px;
}

.calendar-header h1 {
    color: #1a3b2e;
    font-size: 24px;
    margin-bottom: 5px;
}

.calendar-header p {
    color: #6c757d;
    font-size: 14px;
}

.date-selector {
    background: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.date-form {
    display: flex;
    align-items: center;
    gap: 15px;
}

.date-form label {
    font-weight: 500;
    color: #333;
    font-size: 14px;
}

.date-form input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
}

.slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 12px;
}

.slot-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.slot-card.occupied {
    border-left: 3px solid #dc3545;
}

.slot-card.free {
    border-left: 3px solid #28a745;
}

.slot-time {
    background: #f8f9fa;
    padding: 8px 12px;
    font-size: 16px;
    font-weight: 600;
    color: #1a3b2e;
    border-bottom: 1px solid #eee;
}

.slot-info {
    padding: 10px 12px;
}

.slot-name {
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 4px;
    color: #333;
}

.slot-flat {
    font-size: 13px;
    margin-bottom: 4px;
}

.slot-flat a {
    color: #7b5141;
    text-decoration: none;
}

.slot-flat a:hover {
    text-decoration: underline;
}

.slot-phone {
    font-size: 12px;
    color: #666;
}

.slot-free {
    padding: 10px 12px;
    text-align: center;
    color: #28a745;
    font-size: 14px;
}

.empty-state {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 8px;
}

.empty-state p {
    color: #6c757d;
    font-size: 14px;
}

@media (max-width: 768px) {
    .slots-grid {
        grid-template-columns: 1fr;
    }
    
    .date-form {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection