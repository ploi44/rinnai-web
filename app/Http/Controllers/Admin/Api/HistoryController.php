<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function list(Request $request)
    {
        // First order by year desc, then by manual sort_order asc
        $histories = History::orderBy('year', 'desc')
                            ->orderBy('sort_order', 'asc')
                            ->orderBy('id', 'desc')
                            ->get();

        return response()->json([
            'success' => true,
            'data' => $histories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:10',
            'content' => 'required|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $history = History::create($validated);

        return response()->json([
            'success' => true,
            'message' => '연혁이 등록되었습니다.',
            'data' => $history
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:histories,id',
            'year' => 'sometimes|string|max:10',
            'content' => 'sometimes|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $history = History::findOrFail($request->input('id'));
        $history->update($request->only(['year', 'content', 'is_active', 'sort_order']));

        return response()->json([
            'success' => true,
            'message' => '연혁 정보가 수정되었습니다.',
            'data' => $history
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:histories,id'
        ]);

        $history = History::findOrFail($request->input('id'));
        $history->delete();

        return response()->json([
            'success' => true,
            'message' => '연혁이 삭제되었습니다.'
        ]);
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items'); // array of ['id' => 1, 'sort_order' => 1]
        if (is_array($items)) {
            foreach ($items as $item) {
                History::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ]);
    }
}
