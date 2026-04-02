<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function list(Request $request)
    {
        $boards = Board::orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $boards
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:boards,slug',
            'type' => 'required|in:general,album,youtube',
            'pagesize' => 'required|integer|min:0',
        ]);

        $board = Board::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Board created successfully.',
            'data' => $board
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:boards,id',
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:general,album,youtube',
            'pagesize' => 'required|integer|min:0',
        ]);

        $board = Board::findOrFail($request->input('id'));
        $board->update($request->only(['name', 'type', 'pagesize']));

        return response()->json([
            'success' => true,
            'message' => 'Board updated successfully.',
            'data' => $board
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:boards,id',
        ]);

        $board = Board::findOrFail($request->input('id'));
        $board->delete();

        return response()->json([
            'success' => true,
            'message' => 'Board deleted successfully.'
        ]);
    }
}
