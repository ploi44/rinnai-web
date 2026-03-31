<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function list(Request $request)
    {
        $is_active = $request->is_active ?? "";
        $notices = Notice::where(function ($query) use ($is_active) {
            if($is_active != ""){
                $query->where('is_active', $is_active);
            }
        })
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $notices
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'link_url' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $notice = Notice::create($validated);

        return response()->json([
            'success' => true,
            'message' => '주요안내가 등록되었습니다.',
            'data' => $notice
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notices,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'link_url' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $notice = Notice::findOrFail($request->input('id'));
        $notice->update($request->only(['title', 'content', 'link_url', 'is_active', 'sort_order']));

        return response()->json([
            'success' => true,
            'message' => '주요안내 정보가 수정되었습니다.',
            'data' => $notice
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notices,id'
        ]);

        $notice = Notice::findOrFail($request->input('id'));
        $notice->delete();

        return response()->json([
            'success' => true,
            'message' => '주요안내가 삭제되었습니다.'
        ]);
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items'); // array of ['id' => 1, 'sort_order' => 1]
        if (is_array($items)) {
            foreach ($items as $item) {
                Notice::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ]);
    }
}
