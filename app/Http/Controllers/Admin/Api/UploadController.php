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
            'file' => 'required|file|max:102400', // 100MB max
            'folder' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Determine storage path safely
            $folder = $request->input('folder');
            if ($folder) {
                // Remove trailing/leading slashes and prevent directory traversal
                $folder = trim(str_replace('..', '', $folder), '/');
                $subPath = 'uploads/' . $folder;
            } else {
                $subPath = 'uploads';
            }
            
            // Store the file in the public disk, under the calculated directory
            $path = $file->store($subPath, 'public');

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
