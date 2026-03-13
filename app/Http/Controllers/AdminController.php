<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\User;
use App\Models\CallRequest; 
use App\Models\Application;
use App\Models\BuybackRequest;
use Illuminate\Http\Request; // ← ЭТО ВАЖНО!

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'flats_count' => Flat::count(),
            'users_count' => User::count(),
            'available_flats' => Flat::where('status', 'available')->count(),
            'sold_flats' => Flat::where('status', 'sold')->count(),
        ];

        return view('admin.index', $data);
    }






////////////////////////

 public function applications(Request $request)
    {
        $status = $request->get('status');
        $type = $request->get('type'); // 'call' или 'buyback'
        
        // Получаем обычные заявки
        $applicationsQuery = Application::with(['user', 'flat']);
        
        // Получаем заявки на возврат
        $buybackQuery = BuybackRequest::with('user');
        
        // Фильтр по статусу
        if ($status) {
            $applicationsQuery->where('status', $status);
            $buybackQuery->where('status', $status);
        }
        
        // Фильтр по типу
        if ($type === 'call') {
            $applications = $applicationsQuery->latest()->paginate(20);
            return view('admin.applications', compact('applications'));
        } elseif ($type === 'buyback') {
            $buybackRequests = $buybackQuery->latest()->paginate(20);
            return view('admin.buyback', compact('buybackRequests'));
        }
        
        // Получаем все
        $applications = $applicationsQuery->latest()->get();
        $buybackRequests = $buybackQuery->latest()->get();
        
        // Объединяем и сортируем
        $allApplications = $applications->concat($buybackRequests)
            ->sortByDesc('created_at');
        
        // Пагинация
        $perPage = 20;
        $page = $request->get('page', 1);
        $items = $allApplications->forPage($page, $perPage);
        
        $applications = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $allApplications->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('admin.applications', compact('applications'));
    }
    
    // Обновление статуса обычной заявки
    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,processed,called'
        ]);
        
        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();
        
        return redirect()->back()->with('success', 'Статус заявки обновлен');
    }
    
    // Обновление статуса заявки на возврат
    public function updateBuybackStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected,completed'
        ]);
        
        $buyback = BuybackRequest::findOrFail($id);
        $buyback->status = $request->status;
        $buyback->save();
        
        return redirect()->back()->with('success', 'Статус заявки на возврат обновлен');
    }
    
    // Просмотр конкретной заявки
    public function showApplication($id)
    {
        $application = Application::with(['user', 'flat'])->findOrFail($id);
        return view('admin.application-show', compact('application'));
    }
    
    // Просмотр заявки на возврат
    public function showBuyback($id)
    {
        $buyback = BuybackRequest::with('user')->findOrFail($id);
        return view('admin.buyback-show', compact('buyback'));
    }
    
    // Удаление заявки
    public function destroyApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        
        return redirect()->back()->with('success', 'Заявка удалена');
    }
    
    // Удаление заявки на возврат
    public function destroyBuyback($id)
    {
        $buyback = BuybackRequest::findOrFail($id);
        $buyback->delete();
        
        return redirect()->back()->with('success', 'Заявка на возврат удалена');
    }
    
}