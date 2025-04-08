<?php

namespace App\Http\Controllers;

use App\Models\LinkedInProfile;
use App\Services\LinkedInProfileAnalyzer;
use App\Services\PDFExtractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LinkedInProfileController extends Controller
{
    protected $analyzer;
    protected $extractor;

    public function __construct(LinkedInProfileAnalyzer $analyzer, PDFExtractor $extractor)
    {
        $this->analyzer = $analyzer;
        $this->extractor = $extractor;
    }

    public function index()
    {
        $profile = LinkedInProfile::where('user_id', Auth::id())->first();
        return view('linkedin-profile.index', compact('profile'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Starting profile analysis', ['request' => $request->all()]);

            $request->validate([
                'pdf_file' => 'required|file|mimes:pdf|max:10000'
            ]);

            $file = $request->file('pdf_file');
            Log::info('File received', ['file' => $file->getClientOriginalName()]);

            // Store the original PDF
            $path = $file->store('linkedin-profiles', 'public');
            Log::info('File stored', ['path' => $path]);

            // Get the full path to the stored file
            $fullPath = Storage::disk('public')->path($path);

            // Analyze the profile
            $analysis = $this->analyzer->analyzeProfile($fullPath);
            Log::info('Analysis completed', ['analysis' => $analysis]);

            if (isset($analysis['error'])) {
                Log::error('Analysis error', ['error' => $analysis['error']]);
                return response()->json([
                    'success' => false,
                    'message' => $analysis['error']
                ], 500);
            }

            // Create or update profile record
            $profile = LinkedInProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'headline' => $analysis['section_scores']['headline'] ?? null,
                    'summary' => $analysis['section_scores']['summary'] ?? null,
                    'experience' => $analysis['section_scores']['experience'] ?? null,
                    'education' => $analysis['section_scores']['education'] ?? null,
                    'skills' => $analysis['section_scores']['skills'] ?? null,
                    'overall_score' => $analysis['overall_score'],
                    'section_scores' => $analysis['section_scores'],
                    'improvement_suggestions' => $analysis['recommendations'],
                    'pdf_path' => $path
                ]
            );

            Log::info('Profile saved', ['profile_id' => $profile->id]);

            return response()->json([
                'success' => true,
                'message' => 'Profile analyzed successfully',
                'data' => $analysis
            ]);

        } catch (\Exception $e) {
            Log::error('Profile analysis failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error analyzing profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $profile = LinkedInProfile::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('linkedin-profile.show', compact('profile'));
    }
} 