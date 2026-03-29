<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function list(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'level' => 'nullable|integer',
            'status' => 'nullable|string' // If you have a status field later
        ]);

        $user = User::findOrFail($request->input('id'));
        if ($request->has('level')) {
            $user->level = $request->input('level');
        }
        
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user
        ]);
    }
}
