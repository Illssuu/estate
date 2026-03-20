<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BuybackRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index() 
{
    $user = Auth::user();

    $favoritesCount = $user->favorites()->count();
    
    // Считаем обычные заявки
    $regularApplicationsCount = $user->applications()->count();
    
    // Считаем заявки на возврат
    $buybackCount = BuybackRequest::where('user_id', $user->id)->count();
    
    // Общее количество заявок
    $applicationCount = $regularApplicationsCount + $buybackCount;
    
    // Получаем обычные заявки
    $regularApplications = $user->applications()
        ->with('flat')
        ->latest()
        ->get();
    
    // Получаем заявки на возврат
    $buybackRequests = BuybackRequest::where('user_id', $user->id)
        ->latest()
        ->get();
    
    // Объединяем и сортируем
    $recentApplications = $regularApplications->concat($buybackRequests)
        ->sortByDesc('created_at')
        ->take(5);
   $appointmentsCount = $user->appointments()->where('status', 'active')->count();
    return view('profile.index', compact(
        'favoritesCount',
        'applicationCount',
        'appointmentsCount',
        'recentApplications'
    ));
}

    // остальные методы без изменений...
    public function favorites() {
        $user = Auth::user();
        $favorites = $user->favorites()->paginate(12);

        return view('profile.favorites', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $flatId)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Не авторизован'
                ], 401);
            }
        
            if ($user->hasFavorite($flatId)) {
                $user->favorites()->detach($flatId);
                $message = 'Квартира удалена из избранного';
                $added = false;
            } else {
                $user->favorites()->attach($flatId);
                $message = 'Квартира добавлена в избранное';
                $added = true;
            }

            return response()->json([
                'success' => true,
                'added' => $added,
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

public function applications(Request $request) 
{
    $user = Auth::user();

    $favoritesCount = $user->favorites()->count();
    
    // Получаем обычные заявки
    $regularApplications = $user->applications()
        ->with('flat')
        ->latest()
        ->get();
    
    // Получаем заявки на возврат
    $buybackRequests = BuybackRequest::where('user_id', $user->id)
        ->latest()
        ->get();
    
    // Объединяем и сортируем
    $applications = $regularApplications->concat($buybackRequests)
        ->sortByDesc('created_at');
    
    $applicationCount = $applications->count();
    
    // Передаем как $applications (как в шаблоне)
    return view('profile.applications', compact(
        'favoritesCount',
        'applicationCount',
        'applications'  // ← теперь называется applications
    ));
}
    public function storeApplication(Request $request) {
        $request->validate([
            'type' => 'required|in:call,viewing',
            'flat_id' => 'nullable|exists:flat,id',
            'viewing_date' => 'nullable|date|after:now',
            'comment' => 'nullable|string|max:500'
        ]);

        $application = new Application();
        $application->user_id = Auth::id();
        $application->flat_id = $request->flat_id;
        $application->type = $request->type;
        $application->viewing_date = $request->viewing_date;
        $application->comment = $request->comment;
        $application->status = 'new';
        $application->save();

        return back()->with('success', 'Заявка успешно отправлена!');
    }

    public function settings() {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Данные профиля успешно обновлены');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|string|confirmed'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Пароль успешно изменён');
    }
    public function appointments()
{
    $appointments = auth()->user()->appointments()
        ->with('flat')
        ->orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->paginate(10);
    
    return view('profile.appointments', compact('appointments'));
}
}