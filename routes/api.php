<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::post('accounts/list', [\App\Http\Controllers\Admin\Api\AccountController::class, 'list']);
    Route::post('accounts/store', [\App\Http\Controllers\Admin\Api\AccountController::class, 'store']);
    Route::post('accounts/update', [\App\Http\Controllers\Admin\Api\AccountController::class, 'update']);
    Route::post('accounts/delete', [\App\Http\Controllers\Admin\Api\AccountController::class, 'delete']);

    Route::post('settings/get', [\App\Http\Controllers\Admin\Api\SettingController::class, 'get']);
    Route::post('settings/save', [\App\Http\Controllers\Admin\Api\SettingController::class, 'save']);

    Route::post('boards/list', [\App\Http\Controllers\Admin\Api\BoardController::class, 'list']);
    Route::post('boards/store', [\App\Http\Controllers\Admin\Api\BoardController::class, 'store']);
    Route::post('boards/update', [\App\Http\Controllers\Admin\Api\BoardController::class, 'update']);
    Route::post('boards/delete', [\App\Http\Controllers\Admin\Api\BoardController::class, 'delete']);

    Route::post("posts/list", [\App\Http\Controllers\Admin\Api\PostController::class, 'list']);
    Route::post("posts/store", [\App\Http\Controllers\Admin\Api\PostController::class, 'store']);
    Route::post("posts/update", [\App\Http\Controllers\Admin\Api\PostController::class, 'update']);
    Route::post("posts/delete", [\App\Http\Controllers\Admin\Api\PostController::class, 'delete']);

    Route::post('categories/list', [\App\Http\Controllers\Admin\Api\CategoryController::class, 'list']);
    Route::post('categories/store', [\App\Http\Controllers\Admin\Api\CategoryController::class, 'store']);
    Route::post('categories/update', [\App\Http\Controllers\Admin\Api\CategoryController::class, 'update']);
    Route::post('categories/delete', [\App\Http\Controllers\Admin\Api\CategoryController::class, 'delete']);

    Route::post('banners/list', [\App\Http\Controllers\Admin\Api\BannerController::class, 'list']);
    Route::post('banners/store', [\App\Http\Controllers\Admin\Api\BannerController::class, 'store']);
    Route::post('banners/update', [\App\Http\Controllers\Admin\Api\BannerController::class, 'update']);
    Route::post('banners/delete', [\App\Http\Controllers\Admin\Api\BannerController::class, 'delete']);
    Route::post('banners/reorder', [\App\Http\Controllers\Admin\Api\BannerController::class, 'reorder']);

    Route::post('popups/list', [\App\Http\Controllers\Admin\Api\PopupController::class, 'list']);
    Route::post('popups/store', [\App\Http\Controllers\Admin\Api\PopupController::class, 'store']);
    Route::post('popups/update', [\App\Http\Controllers\Admin\Api\PopupController::class, 'update']);
    Route::post('popups/delete', [\App\Http\Controllers\Admin\Api\PopupController::class, 'delete']);
    Route::post('popups/reorder', [\App\Http\Controllers\Admin\Api\PopupController::class, 'reorder']);

    Route::post('awards/list', [\App\Http\Controllers\Admin\Api\AwardController::class, 'list']);
    Route::post('awards/store', [\App\Http\Controllers\Admin\Api\AwardController::class, 'store']);
    Route::post('awards/update', [\App\Http\Controllers\Admin\Api\AwardController::class, 'update']);
    Route::post('awards/delete', [\App\Http\Controllers\Admin\Api\AwardController::class, 'delete']);
    Route::post('awards/reorder', [\App\Http\Controllers\Admin\Api\AwardController::class, 'reorder']);

    Route::post('histories/list', [\App\Http\Controllers\Admin\Api\HistoryController::class, 'list']);
    Route::post('histories/store', [\App\Http\Controllers\Admin\Api\HistoryController::class, 'store']);
    Route::post('histories/update', [\App\Http\Controllers\Admin\Api\HistoryController::class, 'update']);
    Route::post('histories/delete', [\App\Http\Controllers\Admin\Api\HistoryController::class, 'delete']);
    Route::post('histories/reorder', [\App\Http\Controllers\Admin\Api\HistoryController::class, 'reorder']);

    Route::post('notices/list', [\App\Http\Controllers\Admin\Api\NoticeController::class, 'list']);
    Route::post('notices/store', [\App\Http\Controllers\Admin\Api\NoticeController::class, 'store']);
    Route::post('notices/update', [\App\Http\Controllers\Admin\Api\NoticeController::class, 'update']);
    Route::post('notices/delete', [\App\Http\Controllers\Admin\Api\NoticeController::class, 'delete']);
    Route::post('notices/reorder', [\App\Http\Controllers\Admin\Api\NoticeController::class, 'reorder']);

    Route::post('youtube/fetch', [\App\Http\Controllers\Admin\Api\YoutubeController::class, 'fetch']);
    
    Route::post('upload', [\App\Http\Controllers\Admin\Api\UploadController::class, 'upload']);
});
