<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// 메인페이지
Route::get('/', function () {
    $mainSlides = \App\Models\Banner::where("is_active", 1)->orderBy("sort_order", "asc")->get();
    $notices = \App\Models\Notice::where("is_active", 1)->orderBy("sort_order", "asc")->get();
    $posts = \App\Models\Post::where("board_id", 1)->orderBy("created_at", "desc")->get();
    $popups = \App\Models\Popup::where("is_active", 1)
        ->where(function($query) {
            $query->whereNull("start_date")->orWhereDate("start_date", "<=", now());
        })
        ->where(function($query) {
            $query->whereNull("end_date")->orWhereDate("end_date", ">=", now());
        })
        ->orderBy("sort_order", "asc")->get();

    return view('front.main', compact('mainSlides', 'notices', 'posts', 'popups'));
});

// 기업개요
Route::prefix("corp")->group(function() {
    Route::view("idea", "front.corp.idea")->name("front.corp.idea");
    Route::view("brand", "front.corp.brand")->name("front.corp.brand");
    Route::get("company", function() {
        $awards = \App\Models\Award::where("is_active", 1)->orderBy("order", "asc")->get();
        return view("front.corp.company", compact("awards"));
    })->name("front.corp.company");
    Route::get("history", function() {
        $histories = \App\Models\History::where("is_active", 1)->orderBy("year", "asc")->orderBy("sort_order", "asc")->get();
        return view("front.corp.history", compact("histories"));
    })->name("front.corp.history");
    Route::view("safetyManagement", "front.corp.safetyManagement")->name("front.corp.safetyManagement");
});

Route::prefix("board")->group(function() {
    Route::get("{board_id}", "App\Http\Controllers\Front\Board\BoardController@index");
    Route::get("{board_id}/{post_id}", "App\Http\Controllers\Front\Board\BoardController@view");
});

// Admin UI Routes
Route::prefix('admin')->group(function () {
    Route::get('login', function () {
        if (auth()->check()) {
            return redirect()->route('admin.settings.index');
        }
        return view('admin.login');
    })->name('admin.login');



    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/admin/settings');
        Route::view('accounts', 'admin.accounts.index')->name('admin.accounts.index');
        Route::view('settings', 'admin.settings.index')->name('admin.settings.index');
        Route::view('boards', 'admin.boards.index')->name('admin.boards.index');
        Route::view('boards/create', 'admin.boards.create')->name('admin.boards.create');

        // Posts Management
        Route::get('boards/{slug}/posts', function($slug) {
            $board = \App\Models\Board::where('slug', $slug)->firstOrFail();
            return view('admin.boards.posts.index', compact('board'));
        })->name('admin.posts.index');

        Route::get('boards/{slug}/posts/create', function($slug) {
            $board = \App\Models\Board::where('slug', $slug)->firstOrFail();
            return view('admin.boards.posts.form', compact('board'));
        })->name('admin.posts.create');

        Route::get('boards/{slug}/posts/{id}/edit', function($slug, $id) {
            $board = \App\Models\Board::where('slug', $slug)->firstOrFail();
            $post = \App\Models\Post::findOrFail($id);
            return view('admin.boards.posts.form', compact('board', 'post'));
        })->name('admin.posts.edit');
        Route::view('banners', 'admin.banners.index')->name('admin.banners.index');
        Route::view('popups', 'admin.popups.index')->name('admin.popups.index');
        Route::view('awards', 'admin.awards.index')->name('admin.awards.index');
        Route::view('histories', 'admin.histories.index')->name('admin.histories.index');
        Route::view('notices', 'admin.notices.index')->name('admin.notices.index');
    });
});

require __DIR__.'/auth.php';
