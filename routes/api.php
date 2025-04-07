<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileAnalysisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Firebase Authentication Routes
Route::prefix('auth/firebase')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');
});

Route::middleware('auth:sanctum')->group(function () {
    // Profile Analysis Routes
    Route::post('/profiles/{profile}/analyze', [ProfileAnalysisController::class, 'analyzeProfile']);
    Route::get('/profiles/{profile}/scores', [ProfileAnalysisController::class, 'getProfileScores']);
}); 