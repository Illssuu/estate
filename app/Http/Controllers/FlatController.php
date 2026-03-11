<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    // СПИСОК всех квартир
    public function index()
    {
        $flats = Flat::latest()->paginate(10);
        return view('admin.flats.index', compact('flats'));
    }

    // ФОРМА создания новой квартиры
    public function create()
    {
        return view('admin.flats.create');
    }

    // СОХРАНЕНИЕ новой квартиры
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'rooms' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'floor' => 'required|integer',
            'status' => 'required'
        ]);

        Flat::create($request->all());

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира добавлена');
    }

    // ФОРМА редактирования квартиры
    public function edit(Flat $flat)
    {
        return view('admin.flats.edit', compact('flat'));
    }

    // ОБНОВЛЕНИЕ квартиры
    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'title' => 'required',
            'rooms' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'floor' => 'required|integer',
            'status' => 'required'
        ]);

        $flat->update($request->all());

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира обновлена');
    }

    // УДАЛЕНИЕ квартиры
    public function destroy(Flat $flat)
    {
        $flat->delete();

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира удалена');
    }
}