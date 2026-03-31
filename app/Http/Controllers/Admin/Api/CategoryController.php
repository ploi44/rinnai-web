<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardCategory;
use App\Models\Board;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        $request->validate(['board_id' => 'required|exists:boards,id']);
        
        $categories = BoardCategory::where('board_id', $request->board_id)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'board_id' => 'required|exists:boards,id',
            'name' => 'required|string|max:255',
            'order' => 'integer|default:0'
        ]);

        $category = BoardCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => '카테고리가 생성되었습니다.',
            'data' => $category
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:board_categories,id',
            'name' => 'sometimes|string|max:255',
            'order' => 'sometimes|integer'
        ]);

        $category = BoardCategory::findOrFail($request->input('id'));
        $category->update($request->only(['name', 'order']));

        return response()->json([
            'success' => true,
            'message' => '카테고리가 수정되었습니다.',
            'data' => $category
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:board_categories,id'
        ]);

        // Posts utilizing this category will have category_id set to NULL due to nullOnDelete.
        $category = BoardCategory::findOrFail($request->input('id'));
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => '카테고리가 삭제되었습니다.'
        ]);
    }
}
