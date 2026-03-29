<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::post('accounts/list', [\App\Http\Controllers\Admin\Api\AccountController::class, 'list']);
    Route::post('accounts/update', [\App\Http\Controllers\Admin\Api\AccountController::class, 'update']);
    
    Route::post('settings/get', [\App\Http\Controllers\Admin\Api\SettingController::class, 'get']);
    Route::post('settings/save', [\App\Http\Controllers\Admin\Api\SettingController::class, 'save']);
    
    Route::post('boards/list', [\App\Http\Controllers\Admin\Api\BoardController::class, 'list']);
    Route::post('boards/store', [\App\Http\Controllers\Admin\Api\BoardController::class, 'store']);
    Route::post('boards/update', [\App\Http\Controllers\Admin\Api\BoardController::class, 'update']);
    Route::post('boards/delete', [\App\Http\Controllers\Admin\Api\BoardController::class, 'delete']);
    
    Route::post('banners/list', [\App\Http\Controllers\Admin\Api\BannerController::class, 'list']);
    Route::post('banners/store', [\App\Http\Controllers\Admin\Api\BannerController::class, 'store']);
    Route::post('banners/update', [\App\Http\Controllers\Admin\Api\BannerController::class, 'update']);
    Route::post('banners/delete', [\App\Http\Controllers\Admin\Api\BannerController::class, 'delete']);
    
    Route::post('popups/list', [\App\Http\Controllers\Admin\Api\PopupController::class, 'list']);
    Route::post('popups/store', [\App\Http\Controllers\Admin\Api\PopupController::class, 'store']);
    Route::post('popups/update', [\App\Http\Controllers\Admin\Api\PopupController::class, 'update']);
    Route::post('popups/delete', [\App\Http\Controllers\Admin\Api\PopupController::class, 'delete']);
    
    Route::post('upload', [\App\Http\Controllers\Admin\Api\UploadController::class, 'upload']);
});
