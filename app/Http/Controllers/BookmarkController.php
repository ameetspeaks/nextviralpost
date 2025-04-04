<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookmarkedPosts = Post::whereHas('bookmarks', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['postType', 'tone'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        return view('bookmarks.index', compact('bookmarkedPosts'));
    }

    public function toggle(Post $post)
    {
        $user = auth()->user();
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $is_bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $is_bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'is_bookmarked' => $is_bookmarked
        ]);
    }
} 