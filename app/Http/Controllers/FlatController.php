<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\FlatPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // УЖЕ ЕСТЬ

class FlatController extends Controller
{

public function index(Request $request)
{
    // СОЗДАЕМ ЗАПРОС
    $query = Flat::query();

    // ПОИСК ПО НАЗВАНИЮ (должен быть ДО сортировки)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('title', 'LIKE', "%{$search}%");
    }

    // СОРТИРОВКА
    $sort = $request->get('sort', 'id');
    $order = $request->get('order', 'desc');
    
    // Применяем сортировку к запросу
    $query->orderBy($sort, $order);
    
    // ПОЛУЧАЕМ РЕЗУЛЬТАТ
    $flats = $query->paginate(10);

    return view('admin.flats.index', compact('flats', 'sort', 'order'));
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
            'total_floors' => 'required|integer',
            'status' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        // Создаем квартиру
        $flat = Flat::create($request->all());

        // Обрабатываем фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('flats', 'public');
                
                FlatPhoto::create([
                    'flat_id' => $flat->id,
                    'image_path' => $path,
                    'image_name' => $photo->getClientOriginalName(),
                    'sort_order' => $index,
                    'is_main' => $index === 0
                ]);
            }
        }

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира добавлена');
    }

    // ФОРМА редактирования квартиры
    public function edit(Flat $flat)
    {
        return view('admin.flats.edit', compact('flat'));
    }

    // ОБНОВЛЕНИЕ квартиры (ИСПРАВЛЕНО!)
    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'title' => 'required',
            'rooms' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'floor' => 'required|integer',
            'total_floors' => 'required|integer',
            'status' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        // Обновляем основные данные
        $flat->update($request->all());

        // 1. УДАЛЯЕМ отмеченные фото
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = FlatPhoto::find($photoId);
                if ($photo) {
                    // Удаляем файл из storage
                    Storage::disk('public')->delete($photo->image_path);
                    // Удаляем запись из БД
                    $photo->delete();
                }
            }
        }

        // 2. ОБНОВЛЯЕМ главное фото
        if ($request->has('main_photo_id')) {
            // Сбрасываем главное фото у всех
            FlatPhoto::where('flat_id', $flat->id)->update(['is_main' => false]);
            // Устанавливаем новое главное
            $mainPhoto = FlatPhoto::find($request->main_photo_id);
            if ($mainPhoto) {
                $mainPhoto->update(['is_main' => true]);
            }
        }

        // 3. ОБНОВЛЯЕМ сортировку
        if ($request->has('sort_order')) {
            foreach ($request->sort_order as $photoId => $order) {
                FlatPhoto::where('id', $photoId)->update(['sort_order' => $order]);
            }
        }

        // 4. ДОБАВЛЯЕМ новые фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('flats', 'public');
                
                FlatPhoto::create([
                    'flat_id' => $flat->id,
                    'image_path' => $path,
                    'image_name' => $photo->getClientOriginalName(),
                    'sort_order' => $flat->photos()->max('sort_order') + 1 + $index,
                    'is_main' => false // новое фото не главное
                ]);
            }
        }

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира обновлена');
    }

    // УДАЛЕНИЕ квартиры
    public function destroy(Flat $flat)
    {
        // Удаляем фото из storage
        foreach ($flat->photos as $photo) {
            Storage::disk('public')->delete($photo->image_path);
        }
        
        $flat->delete();

        return redirect()->route('admin.flats.index')
            ->with('success', 'Квартира удалена');
    }

    // ДОПОЛНИТЕЛЬНЫЙ МЕТОД для удаления фото (если нужно)
    public function deletePhoto($photoId)
    {
        $photo = FlatPhoto::findOrFail($photoId);
        $flatId = $photo->flat_id;
        
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();
        
        return response()->json(['success' => true]);
    }
}