<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();

        $favoritesCount = $user->favorites()->count();
        $applicationCount =$user->applications()->count();
        $recentApplications = $user->applications()->with('flat')->latest()->take(5)->get();
        return view ('profile.index', compact('user', 'favoritesCount', 'applicationCount', 'recentApplications'));
    }


    public function favorites() {
        $user = Auth::user();
        $favorites = $user->favorites()->paginate(12);

        return view('profile.favorites', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $FlatId) {
        $user = Auth::user();

        if ($user->hasFavorite($FlatId)) {
            $user->favorites()->detach($FlatId);
            $message = 'Квартира удалена из избранного';
            $added = false;
        } else  {
            $user->favorites()->attach($flatId);
            $message = 'Квартира добавлена в избранное';
            $added = true;
        }

        return back()->with('success', $message);
    }


    public function applications() {
        $user = Auth::user();
        $applications = $user->applications()->with('flat')->latest()->paginate(10);

        return view('profile.applications', compact('applications'));
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
}
