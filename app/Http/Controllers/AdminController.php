<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\User;
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
}