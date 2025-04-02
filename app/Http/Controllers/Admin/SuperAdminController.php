<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Template;
use App\Models\Industry;
use App\Models\PostType;
use App\Models\Tone;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'superadmin']);
    }

    /**
     * Show the superadmin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get counts for dashboard cards
        $userCount = User::count();
        $postTypeCount = PostType::count();
        $toneCount = Tone::count();
        $industryCount = Industry::count();
        
        // Get recent templates
        $recentTemplates = Template::with('industry')
            ->latest()
            ->take(5)
            ->get();
            
        // Get recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'userCount',
            'postTypeCount',
            'toneCount',
            'industryCount',
            'recentTemplates',
            'recentUsers'
        ));
    }
} 