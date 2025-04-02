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
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // Social Media Authentication Routes
    Route::get('auth/{provider}', [SocialMediaController::class, 'redirectToProvider'])
        ->name('social.login');
    Route::get('auth/{provider}/callback', [SocialMediaController::class, 'handleProviderCallback'])
        ->name('social.callback');
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Post Generator Routes
    Route::get('/post-generator', [PostGeneratorController::class, 'index'])->name('post-generator.index');
    Route::post('/post-generator/generate', [PostGeneratorController::class, 'generate'])->name('post-generator.generate');
    Route::post('/post-generator/{post}/bookmark', [PostGeneratorController::class, 'bookmark'])->name('post-generator.bookmark');
    Route::post('/post-generator/{post}/feedback', [PostGeneratorController::class, 'feedback'])->name('post-generator.feedback');
    Route::post('/post-generator/{post}/regenerate', [PostGeneratorController::class, 'regenerate'])->name('post-generator.regenerate');
    
    // Viral Content Routes
    Route::get('/viral-content', [ViralContentController::class, 'index'])->name('viral-content.index');
    Route::get('/viral-content/{id}', [ViralContentController::class, 'show'])->name('viral-content.show');
    Route::post('/viral-content/{id}/bookmark', [ViralContentController::class, 'bookmark'])->name('viral-content.bookmark');
    Route::post('/viral-content/{id}/inspire', [ViralContentController::class, 'inspire'])->name('viral-content.inspire');
    
    // Bookmarks Routes
    Route::get('/bookmarks', [ViralContentController::class, 'bookmarks'])->name('bookmarks.index');
    
    // My Posts Routes
    Route::get('/my-posts', [MyPostsController::class, 'index'])->name('my-posts.index');
    Route::get('/my-posts/{id}', [MyPostsController::class, 'show'])->name('my-posts.show');
    Route::post('/my-posts/{id}/copy', [MyPostsController::class, 'copyToClipboard'])->name('my-posts.copy');
    Route::get('/my-posts/{id}/share', [MyPostsController::class, 'shareToLinkedIn'])->name('my-posts.share');
    
    // Social Media Posting Routes
    Route::post('/post/{provider}', [SocialMediaController::class, 'postToSocialMedia'])
        ->name('social.post');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'superadmin'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Add more admin routes here as needed
});

// Superadmin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'superadmin'])->group(function () {
    // Dashboard
    Route::get('/dashboard-sa', [App\Http\Controllers\Admin\SuperAdminController::class, 'dashboard'])->name('dashboard');
    
    // Users
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Post Types
    Route::resource('post-types', App\Http\Controllers\Admin\PostTypeController::class);
    
    // Tones
    Route::resource('tones', App\Http\Controllers\Admin\ToneController::class);
    
    // Industries
    Route::resource('industries', App\Http\Controllers\Admin\IndustryController::class);
    
    // Templates (Viral Recipes)
    Route::resource('templates', App\Http\Controllers\Admin\TemplateController::class);
});
