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
                  ->orWhere('user_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:4',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => '계정이 등록되었습니다.',
            'data' => $user
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'password' => 'nullable|string|min:4',
            'is_active' => 'nullable|boolean'
        ]);

        $user = User::findOrFail($request->input('id'));

        if ($request->has('name')) $user->name = $request->input('name');
        if ($request->has('is_active')) $user->is_active = $request->boolean('is_active');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => '계정 정보가 수정되었습니다.',
            'data' => $user
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->input('id'));

        // Prevent deleting oneself
        if (auth()->id() === $user->id) {
            return response()->json(['success' => false, 'message' => '현재 로그인된 관리자 계정은 삭제할 수 없습니다.'], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => '계정이 삭제되었습니다.'
        ]);
    }
}
