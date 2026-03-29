<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle generic file uploads.
     * Expected input: 'file'
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Store the file in the public disk, under the 'uploads' directory
            $path = $file->store('uploads', 'public');
            
            return response()->json([
                'success' => true,
                'url' => '/storage/' . $path,
                'path' => $path,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.'
        ], 400);
    }
}
