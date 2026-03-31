<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function list(Request $request)
    {
        $request->validate(['board_id' => 'required|exists:boards,id']);
        
        $query = Post::with(['user', 'category'])
            ->where('board_id', $request->board_id);
            
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);
            
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'board_id' => 'required|exists:boards,id',
            'category_id' => 'nullable|exists:board_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'attachments' => 'nullable|array'
        ]);

        $validated['user_id'] = Auth::id(); // Typically the admin user's ID
        
        $post = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => '게시글이 성공적으로 작성되었습니다.',
            'data' => $post
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
            'category_id' => 'nullable|exists:board_categories,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'attachments' => 'nullable|array'
        ]);

        $post = Post::findOrFail($request->input('id'));
        $post->update($request->only(['category_id', 'title', 'content', 'thumbnail', 'attachments']));

        return response()->json([
            'success' => true,
            'message' => '게시글이 성공적으로 수정되었습니다.',
            'data' => $post
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id'
        ]);

        $post = Post::findOrFail($request->input('id'));
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => '게시글이 삭제되었습니다.'
        ]);
    }
}
