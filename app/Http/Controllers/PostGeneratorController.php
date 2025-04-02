<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\Tone;
use App\Models\PromptTemplate;
use App\Models\UserPreference;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Bookmark;

class PostGeneratorController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        $postTypes = PostType::all();
        $tones = Tone::all();
        return view('post-generator.index', compact('postTypes', 'tones'));
    }

    public function generate(Request $request)
    {
        try {
            Log::info('Starting post generation', ['request' => $request->all()]);

            $validated = $request->validate([
                'post_type_id' => 'required|exists:post_types,id',
                'tone_id' => 'required|exists:tones,id',
                'keywords' => 'required|string|max:255',
                'word_limit' => 'required|integer|min:50|max:1000',
                'raw_content' => 'required|string',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Get the prompt template
            $template = PromptTemplate::where('post_type_id', $validated['post_type_id'])
                ->where('tone_id', $validated['tone_id'])
                ->where('is_active', true)
                ->first();

            if (!$template) {
                Log::error('No active prompt template found', [
                    'post_type_id' => $validated['post_type_id'],
                    'tone_id' => $validated['tone_id']
                ]);
                return response()->json([
                    'error' => 'No active prompt template found for the selected post type and tone combination.'
                ], 404);
            }

            // Get user preferences for industry and role
            $userPreferences = UserPreference::where('user_id', auth()->id())->first();
            if (!$userPreferences) {
                Log::error('User preferences not found', ['user_id' => auth()->id()]);
                return response()->json([
                    'error' => 'User preferences not found. Please complete your profile first.'
                ], 404);
            }

            // Store the original template content
            $originalTemplate = $template->content;

            // Replace placeholders in the correct order
            $prompt = $template->content;
            
            // Replace placeholders with user data
            $replacements = [
                '[Industry]' => $userPreferences->industry->name ?? 'Professional',
                '[Role]' => $userPreferences->role->name ?? 'Professional',
                '[What is Post About]' => $validated['raw_content'],
                '[Keyword(s)]' => $validated['keywords'],
                '[Word Limit]' => $validated['word_limit']
            ];

            foreach ($replacements as $placeholder => $value) {
                $prompt = str_replace($placeholder, $value, $prompt);
            }

            // Clean up any double spaces or empty lines
            $prompt = preg_replace('/\s+/', ' ', $prompt);
            $prompt = trim($prompt);

            Log::info('Generated prompt', [
                'original_template' => $originalTemplate,
                'processed_prompt' => $prompt,
                'replacements' => $replacements
            ]);

            // Generate content using Gemini
            $generatedContent = $this->geminiService->generateContent($prompt);

            Log::info('Generated content received', ['content' => $generatedContent]);

            // Create the post
            $post = Post::create([
                'user_id' => auth()->id(),
                'post_type_id' => $validated['post_type_id'],
                'tone_id' => $validated['tone_id'],
                'keywords' => $validated['keywords'],
                'raw_content' => $validated['raw_content'],
                'word_limit' => $validated['word_limit'],
                'prompt' => $prompt, // Store the processed prompt with user input
                'generated_content' => $generatedContent,
            ]);

            Log::info('Post created successfully', ['post_id' => $post->id]);

            return response()->json([
                'success' => true,
                'generated_content' => $generatedContent,
                'post_id' => $post->id
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Model not found', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Required data not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error generating post', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'An error occurred while generating the post',
                'message' => $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function bookmark(Post $post)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error updating bookmark status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to update bookmark status'
            ], 500);
        }
    }

    public function feedback(Post $post, Request $request)
    {
        try {
            $validated = $request->validate([
                'feedback' => 'required|in:positive,negative'
            ]);

            $post->update([
                'feedback' => $validated['feedback'],
                'feedback_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Feedback recorded successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording feedback: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to record feedback'
            ], 500);
        }
    }

    public function regenerate(Post $post)
    {
        try {
            if ($post->regeneration_attempts >= 2) {
                return response()->json([
                    'error' => 'Maximum regeneration attempts reached. Please try again later.',
                    'can_regenerate' => false
                ], 429);
            }

            // Get the prompt template
            $template = PromptTemplate::where('post_type_id', $post->post_type_id)
                ->where('tone_id', $post->tone_id)
                ->where('is_active', true)
                ->first();

            if (!$template) {
                return response()->json([
                    'error' => 'No active prompt template found for the selected post type and tone combination.'
                ], 404);
            }

            // Get user preferences for industry and role
            $userPreferences = UserPreference::where('user_id', auth()->id())->first();
            if (!$userPreferences) {
                return response()->json([
                    'error' => 'User preferences not found. Please complete your profile first.'
                ], 404);
            }

            // Generate new content using the same prompt
            $generatedContent = $this->geminiService->generateContent($post->prompt);

            // Update the post with new content and increment regeneration attempts
            $post->update([
                'generated_content' => $generatedContent,
                'regeneration_attempts' => $post->regeneration_attempts + 1,
                'feedback' => null,
                'feedback_at' => null
            ]);

            return response()->json([
                'success' => true,
                'generated_content' => $generatedContent,
                'regeneration_attempts' => $post->regeneration_attempts,
                'can_regenerate' => $post->regeneration_attempts < 2
            ]);

        } catch (\Exception $e) {
            Log::error('Error regenerating post', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'An error occurred while regenerating the post',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 