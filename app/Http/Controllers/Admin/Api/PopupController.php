<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function list(Request $request)
    {
        $popups = Popup::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
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
            'sort_order' => 'integer',
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
            'sort_order' => 'integer',
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

    public function reorder(Request $request)
    {
        $items = $request->input('items'); // array of ['id' => 1, 'sort_order' => 1]
        if (is_array($items)) {
            foreach ($items as $item) {
                Popup::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ]);
    }
}
