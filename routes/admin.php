<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\ToneController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ViralTemplateController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TrendingPromptController;

Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-sa', [SuperAdminController::class, 'dashboard'])->name('dashboard-sa');
    
    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/preferences', [UserController::class, 'storePreferences'])->name('users.preferences.store');
    Route::put('users/{user}/preferences', [UserController::class, 'updatePreferences'])->name('users.preferences.update');
    Route::put('users/{user}/basic', [UserController::class, 'updateBasic'])->name('users.update.basic');
    Route::put('users/{user}/subscription', [UserController::class, 'updateSubscription'])->name('users.update.subscription');
    Route::put('users/{user}/admin', [UserController::class, 'updateAdmin'])->name('users.update.admin');
    
    // Post Types Management
    Route::resource('post-types', PostTypeController::class);
    Route::post('post-types/{postType}/toggle-status', [PostTypeController::class, 'toggleStatus'])->name('post-types.toggle-status');
    
    // Tones Management
    Route::resource('tones', ToneController::class);
    Route::post('tones/{tone}/toggle-status', [ToneController::class, 'toggleStatus'])->name('tones.toggle-status');
    
    // Industries Management
    Route::resource('industries', IndustryController::class);
    Route::post('industries/{industry}/toggle-status', [IndustryController::class, 'toggleStatus'])->name('industries.toggle-status');
    
    // Templates Management
    Route::get('templates/export', [TemplateController::class, 'export'])->name('templates.export');
    Route::post('templates/import', [TemplateController::class, 'import'])->name('templates.import');
    Route::resource('templates', TemplateController::class);
    Route::post('templates/{template}/toggle-status', [TemplateController::class, 'toggleStatus'])->name('templates.toggle-status');
    
    // Roles Management
    Route::get('roles/export', [RoleController::class, 'export'])->name('roles.export');
    Route::post('roles/import', [RoleController::class, 'import'])->name('roles.import');
    Route::resource('roles', RoleController::class);
    Route::post('roles/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
    
    // Viral Templates Management
    Route::get('viral-templates/export', [ViralTemplateController::class, 'export'])->name('viral-templates.export');
    Route::post('viral-templates/import', [ViralTemplateController::class, 'import'])->name('viral-templates.import');
    Route::resource('viral-templates', ViralTemplateController::class);
    Route::post('viral-templates/{template}/toggle-status', [ViralTemplateController::class, 'toggleStatus'])->name('viral-templates.toggle-status');
    
    // Posts Management
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    
    // Subscription Plans Management
    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::post('subscription-plans/{subscription}/toggle-status', [SubscriptionPlanController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Trending Prompts Management
    Route::resource('trending-prompts', TrendingPromptController::class);
    Route::post('trending-prompts/{prompt}/toggle-status', [TrendingPromptController::class, 'toggleStatus'])->name('trending-prompts.toggle-status');
    Route::get('trending-prompts/{trendingPrompt}', [TrendingPromptController::class, 'show'])->name('trending-prompts.show');
}); 