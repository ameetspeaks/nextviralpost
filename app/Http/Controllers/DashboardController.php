<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneratedPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $totalPosts = GeneratedPost::where('user_id', $user->id)->count();
        
        // For now, we'll use placeholder values for these metrics
        // In a real application, these would be calculated based on actual engagement data
        $engagementRate = '0%';
        $viralScore = 0;

        return view('dashboard', compact('totalPosts', 'engagementRate', 'viralScore'));
    }
} 