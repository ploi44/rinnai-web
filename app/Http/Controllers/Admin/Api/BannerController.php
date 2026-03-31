<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function list(Request $request)
    {
        $is_active = $request->is_active ?? "";

        $banners = Banner::where(function ($query) use ($is_active) {
            if ($is_active != "") {
                $query->where('is_active', $is_active);
            }
        })
        ->orderBy('sort_order', 'asc')->get();
        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'pc_image' => 'required|string',
            'mobile_image' => 'nullable|string',
            'link' => 'nullable|string',
            'target' => 'nullable|string',
            'sort_order' => 'integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $banner = Banner::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Banner created successfully.',
            'data' => $banner
        ]);
    }

    public function update(Request $request)
    {
        $banner = Banner::findOrFail($request->id);

        $data = $request->validate([
            'title' => 'nullable|string',
            'pc_image' => 'required|string',
            'mobile_image' => 'nullable|string',
            'link' => 'nullable|string',
            'target' => 'nullable|string',
            'sort_order' => 'integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $banner->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Banner updated successfully.',
            'data' => $banner
        ]);
    }

    public function delete(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items'); // array of ['id' => 1, 'sort_order' => 1]
        if (is_array($items)) {
            foreach ($items as $item) {
                Banner::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '순서가 변경되었습니다.'
        ]);
    }
}
