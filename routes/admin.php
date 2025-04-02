<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Posts Management
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts/{post}/reject', [PostController::class, 'reject'])->name('posts.reject');
    
    // Templates Management
    Route::resource('templates', TemplateController::class);
    Route::post('templates/{template}/toggle-status', [TemplateController::class, 'toggleStatus'])->name('templates.toggle-status');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
}); 