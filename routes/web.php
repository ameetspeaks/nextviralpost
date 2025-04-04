<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostGeneratorController;
use App\Http\Controllers\ViralTemplateController;
use App\Http\Controllers\ViralContentController;
use App\Http\Controllers\MyPostsController;
use App\Http\Controllers\BookmarkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Onboarding Routes
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store']);

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Post Generator Routes
    Route::get('/post-generator', [PostGeneratorController::class, 'index'])->name('post-generator.index');
    Route::post('/post-generator/generate', [PostGeneratorController::class, 'generate'])->name('post-generator.generate');
    Route::post('/post-generator/check-template', [PostGeneratorController::class, 'checkTemplate'])->name('post-generator.check-template');
    Route::post('/post-generator/{post}/bookmark', [PostGeneratorController::class, 'bookmark'])->name('post-generator.bookmark');
    Route::post('/post-generator/{post}/feedback', [PostGeneratorController::class, 'feedback'])->name('post-generator.feedback');
    Route::post('/post-generator/{post}/regenerate', [PostGeneratorController::class, 'regenerate'])->name('post-generator.regenerate');
    
    // Viral Templates Routes
    Route::get('/viral-templates', [ViralTemplateController::class, 'index'])->name('viral-templates.index');
    Route::get('/viral-templates/{id}', [ViralTemplateController::class, 'show'])->name('viral-templates.show');
    Route::post('/viral-templates/{id}/bookmark', [ViralTemplateController::class, 'bookmark'])->name('viral-templates.bookmark');
    Route::post('/viral-templates/{id}/inspire', [ViralTemplateController::class, 'inspire'])->name('viral-templates.inspire');
    
    // Viral Content Routes
    Route::get('/viral-content', [ViralContentController::class, 'index'])->name('viral-content.index');
    Route::get('/viral-content/{id}', [ViralContentController::class, 'show'])->name('viral-content.show');
    Route::post('/viral-content/{id}/bookmark', [ViralContentController::class, 'bookmark'])->name('viral-content.bookmark');
    Route::post('/viral-content/{id}/inspire', [ViralContentController::class, 'inspire'])->name('viral-content.inspire');
    
    // Bookmark routes
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{post}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    
    // My Posts Routes
    Route::get('/my-posts', [MyPostsController::class, 'index'])->name('my-posts.index');
    Route::get('/my-posts/{id}', [MyPostsController::class, 'show'])->name('my-posts.show');
    Route::post('/my-posts/{id}/copy', [MyPostsController::class, 'copyToClipboard'])->name('my-posts.copy');
    Route::get('/my-posts/{id}/share', [MyPostsController::class, 'shareToLinkedIn'])->name('my-posts.share');
});

// Admin routes are now in routes/admin.php
