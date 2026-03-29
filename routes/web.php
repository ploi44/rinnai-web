<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// 메인페이지
Route::view('/', 'front.main');

// 기업개요
Route::prefix("corp")->group(function() {
    Route::view("idea", "front.corp.idea")->name("front.corp.idea");
    Route::view("brand", "front.corp.brand")->name("front.corp.brand");
    Route::view("company", "front.corp.company")->name("front.corp.company");
    Route::view("history", "front.corp.history")->name("front.corp.history");
    Route::view("safetyManagement", "front.corp.safetyManagement")->name("front.corp.safetyManagement");
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
        Route::view('banners', 'admin.banners.index')->name('admin.banners.index');
        Route::view('popups', 'admin.popups.index')->name('admin.popups.index');
    });
});

require __DIR__.'/auth.php';
