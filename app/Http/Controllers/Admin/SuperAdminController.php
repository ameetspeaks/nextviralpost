<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\PostType;
use App\Models\PostTone;
use App\Models\PromptTemplate;
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
        $postCount = Post::count();
        $postTypeCount = PostType::count();
        $toneCount = PostTone::count();
        $templateCount = PromptTemplate::count();

        return view('admin.dashboard', compact(
            'userCount',
            'postCount',
            'postTypeCount',
            'toneCount',
            'templateCount'
        ));
    }
} 