<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneratedPost;
use App\Models\ViralTemplate;
use App\Models\ViralTemplateInteraction;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        
        // Get total posts from posts table based on max ID that is not null
        $totalPosts = Post::whereNotNull('id')->count();
        
        // Calculate engagement rate based on viral templates
        $viralTemplates = ViralTemplate::whereHas('interactions', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        
        $totalEngagements = 0;
        $totalPostsWithEngagement = 0;
        
        foreach ($viralTemplates as $template) {
            $engagements = $template->likes + $template->comments + $template->shares;
            if ($engagements > 0) {
                $totalEngagements += $engagements;
                $totalPostsWithEngagement++;
            }
        }
        
        $engagementRate = $totalPostsWithEngagement > 0 
            ? round(($totalEngagements / $totalPostsWithEngagement) / 100, 1) . '%' 
            : '0%';
        
        // Calculate viral score (based on engagement metrics)
        $viralScore = $totalPostsWithEngagement > 0 
            ? round(($totalEngagements / $totalPostsWithEngagement) / 10) 
            : 0;
        
        // Get recent activity
        $recentPosts = GeneratedPost::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        $recentInteractions = ViralTemplateInteraction::where('user_id', $user->id)
            ->with('viralTemplate')
            ->latest()
            ->take(5)
            ->get();
            
        // Get trending viral templates
        $trendingTemplates = ViralTemplate::withCount('interactions')
            ->orderBy('interactions_count', 'desc')
            ->take(3)
            ->get();
            
        // Get user's bookmarked templates
        $bookmarkedTemplates = ViralTemplate::whereHas('interactions', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('type', 'bookmark');
        })->take(3)->get();

        return view('dashboard', compact(
            'totalPosts', 
            'engagementRate', 
            'viralScore',
            'recentPosts',
            'recentInteractions',
            'trendingTemplates',
            'bookmarkedTemplates'
        ));
    }
} 