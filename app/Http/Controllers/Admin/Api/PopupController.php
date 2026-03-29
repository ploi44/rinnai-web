<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function list(Request $request)
    {
        $popups = Popup::orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $popups
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|string',
            'link' => 'nullable|string',
            'target' => 'nullable|string',
            'position_x' => 'integer',
            'position_y' => 'integer',
            'width' => 'nullable|integer|gt:0',
            'height' => 'nullable|integer|gt:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $popup = Popup::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Popup created successfully.',
            'data' => $popup
        ]);
    }

    public function update(Request $request)
    {
        $popup = Popup::findOrFail($request->id);

        $data = $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|string',
            'link' => 'nullable|string',
            'target' => 'nullable|string',
            'position_x' => 'integer',
            'position_y' => 'integer',
            'width' => 'nullable|integer|gt:0',
            'height' => 'nullable|integer|gt:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $popup->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Popup updated successfully.',
            'data' => $popup
        ]);
    }

    public function delete(Request $request)
    {
        $popup = Popup::findOrFail($request->id);
        $popup->delete();

        return response()->json([
            'success' => true,
            'message' => 'Popup deleted successfully.'
        ]);
    }
}
