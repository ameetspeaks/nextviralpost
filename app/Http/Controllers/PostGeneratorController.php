<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\PostTone;
use App\Models\PromptTemplate;
use App\Models\UserPreference;
use App\Services\GeminiService;
use App\Traits\ManagesCredits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Bookmark;

class PostGeneratorController extends Controller
{
    use ManagesCredits;

    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        $postTypes = PostType::where('is_active', true)->get();
        $tones = PostTone::where('is_active', true)->get();
        
        // Check if user can generate posts
        $canGenerate = $this->canPerformAction();
        
        return view('post-generator.index', compact('postTypes', 'tones', 'canGenerate'));
    }

    public function generate(Request $request)
    {
        try {
            // Check if user can generate posts
            if (!$this->canPerformAction()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Insufficient credits. Please upgrade your subscription to generate more posts.'
                ], 402);
            }

            // Validate request
            $validated = $request->validate([
                'post_type_id' => 'required|exists:post_types,id',
                'tone_id' => 'required|exists:post_tones,id',
                'keywords' => 'required|string|max:255',
                'raw_content' => 'required|string',
                'word_limit' => 'required|integer|min:50|max:300'
            ]);

            // Get user preferences
            $userPreferences = UserPreference::where('user_id', auth()->id())->first();
            if (!$userPreferences) {
                return response()->json([
                    'success' => false,
                    'error' => 'User preferences not found. Please complete your profile first.'
                ], 404);
            }

            // Find the appropriate prompt template
            $template = PromptTemplate::where('post_type_id', $validated['post_type_id'])
                ->where('tone_id', $validated['tone_id'])
                ->where('is_active', true)
                ->first();

            if (!$template) {
                return response()->json([
                    'success' => false,
                    'error' => 'No active prompt template found for the selected post type and tone combination.'
                ], 404);
            }

            // Get post type and tone names
            $postType = PostType::find($validated['post_type_id']);
            $tone = PostTone::find($validated['tone_id']);

            // Prepare user data for prompt generation
            $userData = [
                'raw_content' => $validated['raw_content'],
                'keywords' => $validated['keywords'],
                'word_limit' => $validated['word_limit'],
                'industry' => $userPreferences->industry ? $userPreferences->industry->name : 'Not specified',
                'role' => $userPreferences->role ? $userPreferences->role->name : 'Not specified',
                'post_type' => $postType->name,
                'tone' => $tone->name
            ];

            // Generate the prompt with all placeholders replaced
            $processedPrompt = $template->generatePrompt($userData);

            // Check and deduct credits before generating content
            try {
                $this->deductCredits(1, 'Generated post using ' . $postType->name);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 402);
            }

            // Generate content using the processed prompt
            try {
                $generatedContent = $this->geminiService->generateContent($processedPrompt);
            } catch (\Exception $e) {
                Log::error('Failed to generate content from Gemini API', [
                    'error' => $e->getMessage(),
                    'prompt' => $processedPrompt
                ]);
                throw new \Exception('Failed to generate content: ' . $e->getMessage());
            }

            // Create the post with the processed prompt and generated content
            $post = new Post([
                'user_id' => auth()->id(),
                'post_type_id' => $validated['post_type_id'],
                'tone_id' => $validated['tone_id'],
                'keywords' => $validated['keywords'],
                'raw_content' => $validated['raw_content'],
                'word_limit' => $validated['word_limit'],
                'prompt' => $processedPrompt,
                'generated_content' => $generatedContent,
                'regeneration_attempts' => 0
            ]);

            $post->save();

            Log::info('Post created successfully', [
                'post_id' => $post->id,
                'prompt' => $processedPrompt,
                'content_length' => strlen($generatedContent)
            ]);

            return response()->json([
                'success' => true,
                'post_id' => $post->id,
                'generated_content' => $generatedContent,
                'prompt' => $processedPrompt
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error generating post', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while generating the post',
                'message' => $e->getMessage()
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

            // If feedback is negative and regeneration attempts are less than 2, allow regeneration
            $canRegenerate = false;
            if ($validated['feedback'] === 'negative' && $post->regeneration_attempts < 2) {
                $canRegenerate = true;
            }

            return response()->json([
                'success' => true,
                'message' => 'Feedback recorded successfully',
                'can_regenerate' => $canRegenerate
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

            // Check and deduct credits before regenerating content
            try {
                $this->deductCredits(1, 'Regenerated post #' . $post->id);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'can_regenerate' => false
                ], 402); // 402 Payment Required
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
                'success' => false,
                'error' => 'An error occurred while regenerating the post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkTemplate(Request $request)
    {
        try {
            $validated = $request->validate([
                'post_type_id' => 'required|exists:post_types,id',
                'tone_id' => 'required|exists:post_tones,id'
            ]);

            // Get user preferences
            $userPreferences = UserPreference::where('user_id', auth()->id())->first();
            if (!$userPreferences) {
                return response()->json([
                    'success' => false,
                    'message' => 'User preferences not found. Please complete your profile first.'
                ], 404);
            }

            $template = PromptTemplate::where('post_type_id', $validated['post_type_id'])
                ->where('tone_id', $validated['tone_id'])
                ->where('is_active', true)
                ->first();

            if (!$template) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active prompt template found for the selected post type and tone combination.'
                ], 404);
            }

            // Get industry and role names from user preferences
            $industry = $userPreferences->industry ? $userPreferences->industry->name : 'Not specified';
            $role = $userPreferences->role ? $userPreferences->role->name : 'Not specified';

            // Replace industry and role placeholders in the template
            $processedTemplate = $template->content;
            $processedTemplate = str_replace('{industry}', $industry, $processedTemplate);
            $processedTemplate = str_replace('{role}', $role, $processedTemplate);

            Log::info('Template processed', [
                'original_template' => $template->content,
                'processed_template' => $processedTemplate,
                'industry' => $industry,
                'role' => $role
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Template available',
                'template' => [
                    'id' => $template->id,
                    'content' => $processedTemplate,
                    'placeholders' => [
                        '{keywords}',
                        '{raw_content}',
                        '{word_limit}'
                    ]
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking template availability'
            ], 500);
        }
    }
} 