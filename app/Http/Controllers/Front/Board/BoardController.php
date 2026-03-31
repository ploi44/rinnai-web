<?php
namespace App\Http\Controllers\Front\Board;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Post;

class BoardController extends Controller
{
    public function index($board_id)
    {
        $board = Board::where("slug", $board_id)->first();
        $posts = Post::with(['user', 'category', 'board'])
            ->where('board_id', $board->id)
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view("front.board.{$board_id}", compact('posts', 'board'));
    }

    public function view($board_id, $post_id) {
        $board = Board::where("slug", $board_id)->first();
        $post = Post::with(['user', 'category', 'board'])
            ->where("id", $post_id)
            ->first();

        return view("front.board.view", compact('post', 'board'));
    }
}
