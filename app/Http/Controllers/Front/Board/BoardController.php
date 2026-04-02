<?php
namespace App\Http\Controllers\Front\Board;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Post;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index($board_id, Request $request)
    {
        $board = Board::where("slug", $board_id)->firstOrFail();
        $posts = null;
        $postQuery = Post::with(['user', 'category', 'board'])
            ->where('board_id', $board->id)
            ->orderBy("created_at", "desc");
        if($board->pagesize > 0) {
            $posts = $postQuery->paginate($board->pagesize);
        } else {
            $posts = $postQuery->get();
        }

        return view("front.board.{$board_id}", compact('posts', 'board'));
    }

    public function view($board_id, $post_id) {
        $board = Board::where("slug", $board_id)->firstOrFail();
        $post = Post::with(['user', 'category', 'board'])
            ->where("board_id", $board->id)
            ->where("id", $post_id)
            ->firstOrFail();

        return view("front.board.view", compact('post', 'board'));
    }
}
