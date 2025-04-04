<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViralTemplate;
use App\Models\ViralTemplateInteraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ViralTemplateController extends Controller
{
    public function index()
    {
        $templates = ViralTemplate::with(['interactions' => function($query) {
            $query->where('user_id', Auth::id());
        }])
        ->orderBy('likes', 'desc')
        ->paginate(12);

        return view('viral-templates.index', compact('templates'));
    }

    public function show(ViralTemplate $template)
    {
        $template->load(['interactions' => function($query) {
            $query->where('user_id', Auth::id());
        }]);
        
        return view('viral-templates.show', compact('template'));
    }

    public function bookmark(Request $request, ViralTemplate $template)
    {
        $user = Auth::user();
        $isBookmarked = $template->interactions()
            ->where('user_id', $user->id)
            ->where('type', 'bookmark')
            ->exists();

        if ($isBookmarked) {
            $template->interactions()
                ->where('user_id', $user->id)
                ->where('type', 'bookmark')
                ->delete();
            $template->decrement('bookmark_count');
        } else {
            $template->interactions()->create([
                'user_id' => $user->id,
                'type' => 'bookmark'
            ]);
            $template->increment('bookmark_count');
        }

        return response()->json([
            'success' => true,
            'is_bookmarked' => !$isBookmarked
        ]);
    }

    public function inspire(Request $request, ViralTemplate $template)
    {
        $user = Auth::user();
        
        // Record the inspiration
        $template->interactions()->create([
            'user_id' => $user->id,
            'type' => 'inspire'
        ]);
        $template->increment('inspiration_count');

        return response()->json([
            'success' => true,
            'template' => $template
        ]);
    }
}
