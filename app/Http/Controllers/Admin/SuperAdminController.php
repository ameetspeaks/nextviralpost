<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ViralTemplate;
use App\Models\PostType;
use App\Models\PostTone;
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
        $userCount = User::count();
        $postTypeCount = PostType::count();
        $toneCount = PostTone::count();
        $templateCount = ViralTemplate::count();

        $recentUsers = User::latest()->take(5)->get();
        $recentTemplates = ViralTemplate::latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'userCount',
            'postTypeCount',
            'toneCount',
            'templateCount',
            'recentUsers',
            'recentTemplates'
        ));
    }
} 