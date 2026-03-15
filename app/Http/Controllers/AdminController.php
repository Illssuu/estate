<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\User;
use App\Models\CallRequest; 
use App\Models\Application;
use App\Models\BuybackRequest;
use Illuminate\Http\Request; 

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
    

    // Добавить в AdminController

public function users()
{
    $users = User::latest()->paginate(15);
    return view('admin.users.index', compact('users'));
}
// app/Http/Controllers/AdminController.php

public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|in:user,admin'
    ]);
    
    $user->update(['role' => $request->role]);
    
    return back()->with('success', 'Роль обновлена');
}
// Добавьте этот метод в AdminController

public function destroyUser(User $user)
{
    $user->delete();
    
    return back()->with('success', 'Пользователь удален');
}
  public function updateFlat(Request $request, Flat $flat)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'living_area' => 'nullable|numeric|min:0',
            'rooms' => 'required|integer|min:1',
            'floor' => 'required|integer|min:1',
            'total_floors' => 'required|integer|min:1',
            'housing_type' => 'required|in:new_building,secondary',
            'finishing' => 'required|in:rough,fine,euro,without',
            'view_type' => 'required|in:yard,street,combined',
            'bathroom' => 'required|in:separate,combined',
            'balcony' => 'required|boolean',
            'status' => 'required|in:available,reserved,sold',
            'is_available' => 'required|boolean',
            'main_photo_id' => 'nullable|exists:flat_photos,id',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:flat_photos,id',
            'sort_order' => 'nullable|array',
            'sort_order.*' => 'integer|min:0',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Обновляем основные данные
        $flat->update($validated);

        // Удаление отмеченных фото
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = FlatPhoto::find($photoId);
                if ($photo) {
                    // Удаляем файл
                    Storage::disk('public')->delete($photo->image_path);
                    // Удаляем запись
                    $photo->delete();
                }
            }
        }

        // Обновление порядка сортировки
        if ($request->has('sort_order')) {
            foreach ($request->sort_order as $photoId => $sortOrder) {
                FlatPhoto::where('id', $photoId)
                    ->where('flat_id', $flat->id)
                    ->update(['sort_order' => $sortOrder]);
            }
        }

        // Установка главного фото
        if ($request->has('main_photo_id')) {
            // Сбрасываем флаг is_main у всех фото квартиры
            FlatPhoto::where('flat_id', $flat->id)
                ->update(['is_main' => false]);
            
            // Устанавливаем новое главное фото
            FlatPhoto::where('id', $request->main_photo_id)
                ->where('flat_id', $flat->id)
                ->update(['is_main' => true]);
        }

        // Загрузка новых фото
        if ($request->hasFile('photos')) {
            $maxSortOrder = FlatPhoto::where('flat_id', $flat->id)->max('sort_order') ?? 0;
            
            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('flats/' . $flat->id, 'public');
                
                FlatPhoto::create([
                    'flat_id' => $flat->id,
                    'image_path' => $path,
                    'image_name' => $file->getClientOriginalName(),
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_main' => false // Новые фото не главные по умолчанию
                ]);
            }
        }

        // Если после всех операций нет главного фото, назначаем первое
        if (!FlatPhoto::where('flat_id', $flat->id)->where('is_main', true)->exists()) {
            $firstPhoto = FlatPhoto::where('flat_id', $flat->id)->orderBy('sort_order')->first();
            if ($firstPhoto) {
                $firstPhoto->update(['is_main' => true]);
            }
        }

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира успешно обновлена');
    }
    
}
