<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuybackRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Добавляем Auth

class BuybackController extends Controller
{
    // Показать страницу с информацией о возврате
    public function index()
    {
        return view('flats.buyback');
    }
    
    // Обработка заявки на возврат
    public function store(Request $request)
    {
        // Валидация на сервере
        $data = $request->validate([
            'contract_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zА-Яа-яЁё0-9-]+$/u'
            ],
            'contract_date' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[А-Яа-яЁё\s-]+$/u'
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+7\d{10}$/'
            ],
            'contract_scan' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120'
            ],
        ], [
            'contract_number.required' => 'Номер договора обязателен для заполнения',
            'contract_number.regex' => 'Номер договора может содержать только буквы, цифры и дефис',
            'contract_date.required' => 'Дата договора обязательна',
            'contract_date.before_or_equal' => 'Дата договора не может быть позже сегодняшнего дня',
            'name.required' => 'ФИО обязательно для заполнения',
            'name.regex' => 'ФИО может содержать только русские буквы, пробелы и дефис',
            'phone.required' => 'Телефон обязателен для заполнения',
            'phone.regex' => 'Телефон должен быть в формате +7XXXXXXXXXX (10 цифр после +7)',
            'contract_scan.required' => 'Скан договора обязателен',
            'contract_scan.mimes' => 'Файл должен быть в формате PDF, JPG или PNG',
            'contract_scan.max' => 'Размер файла не должен превышать 5 МБ',
        ]);
        
        try {
            // Сохраняем файл
            if ($request->hasFile('contract_scan')) {
                $path = $request->file('contract_scan')->store('buyback_docs', 'public');
                $data['contract_scan_images'] = json_encode([$path]);
            }
            
            // Добавляем статус
            $data['status'] = 'new';
            
            // Добавляем ID текущего пользователя (если авторизован)
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }
            
            // Удаляем поле contract_scan из данных (не нужно сохранять в БД)
            unset($data['contract_scan']);
            
            // Сохраняем заявку
            BuybackRequest::create($data);
            
            // Логируем успешную отправку
            Log::info('Заявка на обратный выкуп создана', [
                'contract_number' => $data['contract_number'],
                'user_id' => Auth::id() ?? 'не авторизован'
            ]);
            
            return redirect()->back()->with('success', 'Заявка отправлена! Менеджер свяжется с вами в течение 24 часов.');
            
        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Ошибка при создании заявки на выкуп', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте позже.')
                ->withInput();
        }
    }
}