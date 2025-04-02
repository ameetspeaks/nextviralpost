<?php

namespace App\Http\Controllers;

use App\Models\ViralTemplate;
use App\Models\ViralTemplateInteraction;
use Illuminate\Http\Request;

class ViralContentController extends Controller
{
    public function index()
    {
        $templates = ViralTemplate::withCount(['bookmarks', 'inspirations'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('viral-content.index', compact('templates'));
    }

    public function show($id)
    {
        $template = ViralTemplate::with(['bookmarks', 'inspirations'])
            ->findOrFail($id);

        return view('viral-content.show', compact('template'));
    }

    public function bookmark(Request $request, $id)
    {
        $template = ViralTemplate::findOrFail($id);
        $user = $request->user();

        $interaction = ViralTemplateInteraction::where([
            'user_id' => $user->id,
            'viral_template_id' => $template->id,
            'type' => 'bookmark'
        ])->first();

        if ($interaction) {
            $interaction->delete();
            $template->decrement('bookmark_count');
            $is_bookmarked = false;
        } else {
            ViralTemplateInteraction::create([
                'user_id' => $user->id,
                'viral_template_id' => $template->id,
                'type' => 'bookmark'
            ]);
            $template->increment('bookmark_count');
            $is_bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'is_bookmarked' => $is_bookmarked,
            'bookmark_count' => $template->bookmark_count
        ]);
    }

    public function inspire(Request $request, $id)
    {
        $template = ViralTemplate::findOrFail($id);
        $user = $request->user();

        // Validate request
        $validated = $request->validate([
            'tone' => 'required|string|in:insightful,personal,funny,controversial,motivational',
            'additional_context' => 'nullable|string|max:500'
        ]);

        // Store the inspiration interaction
        $interaction = ViralTemplateInteraction::firstOrNew([
            'user_id' => $user->id,
            'viral_template_id' => $template->id,
            'type' => 'inspire'
        ]);

        if (!$interaction->exists) {
            $interaction->save();
            $template->increment('inspiration_count');
        }

        // Store template data in session for post generator
        $request->session()->put('inspiration_template', [
            'original_content' => $template->post_content,
            'tone' => $validated['tone'],
            'additional_context' => $validated['additional_context'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template inspiration stored successfully',
            'template_id' => $template->id
        ]);
    }

    public function bookmarks()
    {
        $user = auth()->user();
        $bookmarkedTemplates = ViralTemplate::whereHas('interactions', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('type', 'bookmark');
        })
        ->withCount(['bookmarks', 'inspirations'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        return view('viral-content.bookmarks', compact('bookmarkedTemplates'));
    }
} 