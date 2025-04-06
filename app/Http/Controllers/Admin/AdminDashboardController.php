<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\PostType;
use App\Models\Tone;
use App\Models\Industry;
use App\Models\Template;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $postTypeCount = PostType::count();
        $toneCount = Tone::count();
        $industryCount = Industry::count();
        $subscriptionPlanCount = SubscriptionPlan::count();
        
        $recentUsers = User::latest()->take(5)->get();
        $recentTemplates = Template::with('industry')->latest()->take(5)->get();
        $recentPlans = SubscriptionPlan::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'userCount',
            'postTypeCount',
            'toneCount',
            'industryCount',
            'subscriptionPlanCount',
            'recentUsers',
            'recentTemplates',
            'recentPlans'
        ));
    }
} 