<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of all posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with(['user', 'postType', 'tone'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        $post->load(['user', 'postType', 'tone']);
        return view('admin.posts.show', compact('post'));
    }
} 