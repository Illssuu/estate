<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\FlatPhoto; // <-- ДОБАВЬТЕ ЭТУ СТРОЧКУ
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        // Начинаем запрос
        $query = Flat::query();
        
        // Фильтр по комнатам
        if ($request->filled('rooms')) {
            if ($request->rooms == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', $request->rooms);
            }
        }
        
        // Фильтр по типу жилья
        if ($request->filled('housing_type')) {
            $query->where('housing_type', $request->housing_type);
        }
        
        // Фильтр по цене
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->has('min_area') && $request->min_area != '') {
            $query->where('area', '>=', $request->min_area);
        }
        // Получаем результаты
        $flats = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('flats.index', compact('flats'));
    }

  

    public function show($id)
    {
        // Используйте eager loading для фотографий
        $flat = Flat::with('photos')->findOrFail($id);
        
        return view('flats.show', compact('flat'));
    }
    
    public function storePhoto(Request $request, $id)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);
        
        $flat = Flat::findOrFail($id);
        
        foreach ($request->file('photos') as $index => $photo) {
            $path = $photo->store('flats/' . $flat->id, 'public');
            
            FlatPhoto::create([
                'flat_id' => $flat->id,
                'image_path' => $path,
                'image_name' => $photo->getClientOriginalName(),
                'sort_order' => $index,
                'is_main' => ($index === 0)
            ]);
        }
        
        return back()->with('success', 'Фотографии успешно загружены');
    }
}