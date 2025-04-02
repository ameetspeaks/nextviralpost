<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Post;
use App\Models\ViralTemplate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_templates' => ViralTemplate::count(),
            'recent_posts' => Post::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $stats);
    }
} 