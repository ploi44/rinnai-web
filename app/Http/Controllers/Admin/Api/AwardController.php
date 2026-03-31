<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Award;

class AwardController extends Controller
{
    public function list(Request $request)
    {
        $query = Award::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $awards = $query->orderBy('order', 'asc')
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $awards
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $award = Award::create($validated);

        return response()->json([
            'success' => true,
            'message' => '수상이 성공적으로 등록되었습니다.',
            'data' => $award
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:awards,id',
            'title' => 'sometimes|string|max:255',
            'image_path' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $award = Award::findOrFail($request->input('id'));
        $award->update($request->only(['title', 'image_path', 'is_active', 'order']));

        return response()->json([
            'success' => true,
            'message' => '수상 정보가 성공적으로 수정되었습니다.',
            'data' => $award
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:awards,id'
        ]);

        $award = Award::findOrFail($request->input('id'));
        $award->delete();

        return response()->json([
            'success' => true,
            'message' => '수상이 성공적으로 삭제되었습니다.'
        ]);
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items'); // array of ['id' => 1, 'order' => 1]
        if (is_array($items)) {
            foreach ($items as $item) {
                Award::where('id', $item['id'])->update(['order' => $item['order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ]);
    }
}
