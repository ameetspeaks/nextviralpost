<?php

namespace App\Http\Controllers;

use App\Models\ViralTemplate;
use App\Models\ViralTemplateInteraction;
use App\Models\TrendingTopic;
use App\Models\ContentIdea;
use App\Models\TopicAnalytic;
use Illuminate\Http\Request;

class ViralContentController extends Controller
{
    public function index()
    {
        // Fetch viral templates
        $viralTemplates = ViralTemplate::latest()->get();

        // Fetch trending topics
        $trendingTopics = TrendingTopic::orderBy('trend_score', 'desc')
            ->take(8)
            ->get();

        // Fetch content ideas
        $contentIdeas = ContentIdea::where('user_id', auth()->id())
            ->latest()
            ->take(4)
            ->get();

        // Fetch topic analytics or create default values
        $analytics = TopicAnalytic::where('user_id', auth()->id())
            ->first() ?? (object)[
                'total_views' => 0,
                'views_change' => 0,
                'engagement_rate' => 0,
                'engagement_change' => 0,
                'top_topic' => 'No data yet',
                'top_topic_views' => 0,
                'avg_time' => 0,
                'time_change' => 0
            ];

        return view('viral-content.index', compact(
            'viralTemplates',
            'trendingTopics',
            'contentIdeas',
            'analytics'
        ));
    }

    public function searchTemplates(Request $request)
    {
        $query = $request->input('query');
        
        $templates = ViralTemplate::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->get();

        return response()->json($templates);
    }

    public function generateContentIdeas(Request $request)
    {
        // Validate the request
        $request->validate([
            'topic_id' => 'required|exists:trending_topics,id',
            'platform' => 'required|in:linkedin,twitter,facebook,instagram',
        ]);

        // Generate content ideas based on the topic and platform
        $ideas = $this->generateIdeas($request->topic_id, $request->platform);

        // Save the generated ideas
        foreach ($ideas as $idea) {
            ContentIdea::create([
                'user_id' => auth()->id(),
                'title' => $idea['title'],
                'description' => $idea['description'],
                'platform' => $request->platform,
                'viral_potential' => $idea['viral_potential'],
            ]);
        }

        return response()->json(['success' => true, 'ideas' => $ideas]);
    }

    public function getAnalytics(Request $request)
    {
        $period = $request->input('period', '7days');
        
        $analytics = TopicAnalytic::where('user_id', auth()->id())
            ->where('period', $period)
            ->first();

        return response()->json($analytics);
    }

    private function generateIdeas($topicId, $platform)
    {
        // This is a placeholder for the actual content generation logic
        // In a real application, you would use an AI service or other methods
        // to generate content ideas based on the topic and platform
        
        $topic = TrendingTopic::find($topicId);
        
        // Generate 3 content ideas
        return [
            [
                'title' => "5 Ways to Leverage {$topic->name} for Business Growth",
                'description' => "Discover how to use {$topic->name} to drive business growth and engagement on {$platform}.",
                'viral_potential' => rand(70, 90),
            ],
            [
                'title' => "The Future of {$topic->name}: Expert Predictions",
                'description' => "Industry experts share their insights on the future of {$topic->name} and what it means for you.",
                'viral_potential' => rand(75, 95),
            ],
            [
                'title' => "{$topic->name} Success Stories: Real Examples",
                'description' => "Learn from real success stories of businesses using {$topic->name} effectively.",
                'viral_potential' => rand(65, 85),
            ],
        ];
    }

    public function show($id)
    {
        $template = ViralTemplate::findOrFail($id);
        $tones = \App\Models\PostTone::where('is_active', true)->get();
        
        return view('viral-content.show', compact('template', 'tones'));
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