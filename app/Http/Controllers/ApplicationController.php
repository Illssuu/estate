<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Flat;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data=$request->validate([
           'name' => 'required|regex:/^[\p{Cyrillic} ]+$/u',
           'phone' => 'required|regex:/^\+7\d{10}$/',
            'flat_id' => 'required|exists:flats,id|integer|min:0',
            'comment' => 'nullable|string|max:500'
        ]);

        $flat = Flat::find($request->flat_id);

    $application=Application::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'flat_id' => $request->flat_id > 0 ? $request->flat_id : null, // если 0 - сохраняем nullы
            'flat_title' => $flat->title,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'status' => 'new'
        ]);

        return redirect()->back()->with('success', 'Заявка успешно отправлена!');
    }

    public function myApplications()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('flat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.applications', compact('applications'));
    }
}