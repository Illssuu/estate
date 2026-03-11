<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\User;
use App\Models\CallRequest; 

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
    я
}