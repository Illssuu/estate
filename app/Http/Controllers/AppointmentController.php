<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function getAvailableSlots(Request $request)
{
    $date = $request->get('date');
    
    if (!$date) {
        return response()->json([]);
    }

    $carbonDate = Carbon::parse($date);
    $today = Carbon::today();
    
    // Все возможные слоты
    $allSlots = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    
    // Если выбранная дата - сегодня, убираем уже прошедшие часы
    if ($carbonDate->isToday()) {
        $currentHour = Carbon::now()->hour;
        $allSlots = array_filter($allSlots, function($slot) use ($currentHour) {
            $slotHour = (int) substr($slot, 0, 2);
            return $slotHour > $currentHour;
        });
        $allSlots = array_values($allSlots);
    }
    
    // Получаем занятые слоты из БД
    $bookedSlots = Appointment::where('date', $date)
        ->whereIn('status', ['active', 'cancelled'])
        ->pluck('time')
        ->map(function($time) {
            // Если time уже строка, берем первые 5 символов
            if (is_string($time)) {
                return substr($time, 0, 5);
            }
            // Если time это объект Carbon
            if ($time instanceof \Carbon\Carbon) {
                return $time->format('H:i');
            }
            // Если это что-то другое, пробуем преобразовать
            return substr((string)$time, 0, 5);
        })
        ->toArray();
    
    // Свободные слоты
    $availableSlots = array_diff($allSlots, $bookedSlots);
    
    return response()->json(array_values($availableSlots));
}
  public function store(Request $request)
{
    $request->validate([
        'flat_id' => 'required|exists:flats,id',
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required|date_format:H:i'
    ]);

    // Проверяем, не занято ли время
    $isBooked = Appointment::where('date', $request->date)
        ->where('time', $request->time . ':00')  // Добавляем :00 для сравнения с БД
        ->whereIn('status', ['active', 'cancelled'])
        ->exists();

    if ($isBooked) {
        return response()->json([
            'success' => false,
            'message' => 'Это время уже занято'
        ], 422);
    }

    // Создаем запись
    Appointment::create([
        'user_id' => auth()->id(),
        'flat_id' => $request->flat_id,
        'date' => $request->date,
        'time' => $request->time . ':00',  // Сохраняем с :00
        'status' => 'active'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Запись создана'
    ]);
}
public function cancel($id)
{
    $appointment = Appointment::findOrFail($id);
    
    // Проверяем, принадлежит ли запись пользователю
    if ($appointment->user_id !== auth()->id()) {
        return response()->json([
            'success' => false,
            'message' => 'Доступ запрещен'
        ], 403);
    }
    
    // Отменяем запись
    $appointment->update(['status' => 'cancelled']);
    
    return response()->json([
        'success' => true,
        'message' => 'Запись отменена'
    ]);
}

}