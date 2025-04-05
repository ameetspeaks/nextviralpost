<?php

namespace App\Http\Controllers;

use App\Models\RepurposedContent;
use App\Models\ViralTemplate;
use App\Models\Tone;
use App\Models\PostTone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class RepurposedContentController extends Controller
{
    public function index()
    {
        $repurposedContent = RepurposedContent::where('user_id', Auth::id())
            ->with(['viralTemplate', 'tone'])
            ->latest()
            ->paginate(10);

        return view('repurposed-content.index', compact('repurposedContent'));
    }

    public function create(ViralTemplate $viralTemplate)
    {
        if (RepurposedContent::hasUserRepurposedTemplate(Auth::id(), $viralTemplate->id)) {
            return redirect()->back()->with('error', 'You have already repurposed this template.');
        }

        $tones = Tone::where('is_active', true)->get();
        return view('repurposed-content.create', compact('viralTemplate', 'tones'));
    }

    public function store(Request $request, ViralTemplate $viralTemplate)
    {
        try {
            // Validate the request
            $request->validate([
                'tone_id' => 'required|exists:post_tones,id',
                'raw_thoughts' => 'required|string|min:10',
            ]);

            // Check if user has already repurposed this template
            $existingRepurpose = RepurposedContent::where('user_id', Auth::id())
                ->where('viral_template_id', $viralTemplate->id)
                ->first();

            if ($existingRepurpose) {
                return response()->json([
                    'error' => 'You have already repurposed this template.'
                ], 422);
            }

            // Get the selected tone
            $tone = PostTone::findOrFail($request->tone_id);

            // Create the prompt with actual data
            $prompt = "Repurpose the given viral LinkedIn post using a {$tone->name} tone. Integrate the user's raw thoughts: \"{$request->raw_thoughts}\" to give it a fresh, personal angle. Start the post with an engaging hook relevant to the topic and tone. Keep the message concise, insightful, and formatted for high engagement. Post should be precise if possible to similar length else within 300 words limit (max). Output only the final LinkedIn post—no extra explanation or formatting.\n\nHere is Viral LinkedIn Post- {$viralTemplate->post_content}";

            // Initialize Gemini API client
            $client = new ServiceBuilder([
                'key' => config('services.gemini.api_key'),
                'projectId' => 'nextviralpost'
            ]);
            
            $gemini = $client->gemini();
            
            // Generate content using Gemini API
            $response = $gemini->generateContent([
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);
            
            $repurposedContent = $response->getText();

            // Create the repurposed content record
            $content = RepurposedContent::create([
                'user_id' => Auth::id(),
                'viral_template_id' => $viralTemplate->id,
                'tone_id' => $tone->id,
                'raw_thoughts' => $request->raw_thoughts,
                'repurposed_content' => $repurposedContent,
                'prompt_used' => $prompt
            ]);

            // Increment repurpose count for the template
            $viralTemplate->increment('repurpose_count');

            return response()->json([
                'success' => true,
                'repurposed_content' => $repurposedContent
            ]);

        } catch (\Exception $e) {
            Log::error('Error in repurposing content: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to generate repurposed content. Please try again.'
            ], 500);
        }
    }

    public function show(RepurposedContent $repurposedContent)
    {
        if ($repurposedContent->user_id !== Auth::id()) {
            abort(403);
        }

        return view('repurposed-content.show', compact('repurposedContent'));
    }
} 