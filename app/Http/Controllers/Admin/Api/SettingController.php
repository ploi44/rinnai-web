<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function get(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully.'
        ]);
    }
}
