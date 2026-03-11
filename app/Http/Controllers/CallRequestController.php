<?php

namespace App\Http\Controllers;

use App\Models\CallRequest;
use App\Models\Flat;
use Illuminate\Http\Request;

class CallRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'flat_id' => 'required|exists:flats,id',
            'comment' => 'nullable|string'
        ]);

        $flat = Flat::find($request->flat_id);

        CallRequest::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'flat_id' => $request->flat_id,
            'flat_title' => $flat->title ?? 'Квартира #' . $request->flat_id,
            'comment' => $request->comment,
            'status' => 'new'
        ]);

        return response()->json(['success' => true]);
    }
}