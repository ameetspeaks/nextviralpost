<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrendingPrompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrendingPromptController extends Controller
{
    public function index()
    {
        $prompts = TrendingPrompt::latest()->paginate(10);
        return view('admin.trending-prompts.index', compact('prompts'));
    }

    public function create()
    {
        return view('admin.trending-prompts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'prompt_template' => 'required|string',
            'requirements' => 'nullable|array',
            'llm_model' => 'required|string',
            'is_paid' => 'required|boolean',
            'free_user_limit' => 'required|integer|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        TrendingPrompt::create($request->all());

        return redirect()->route('admin.trending-prompts.index')
            ->with('success', 'Trending prompt created successfully.');
    }

    public function edit(TrendingPrompt $trendingPrompt)
    {
        return view('admin.trending-prompts.edit', compact('trendingPrompt'));
    }

    public function update(Request $request, TrendingPrompt $trendingPrompt)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'prompt_template' => 'required|string',
            'requirements' => 'nullable|array',
            'llm_model' => 'required|string',
            'is_paid' => 'required|boolean',
            'free_user_limit' => 'required|integer|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $trendingPrompt->update($request->all());

        return redirect()->route('admin.trending-prompts.index')
            ->with('success', 'Trending prompt updated successfully.');
    }

    public function destroy(TrendingPrompt $trendingPrompt)
    {
        $trendingPrompt->delete();

        return redirect()->route('admin.trending-prompts.index')
            ->with('success', 'Trending prompt deleted successfully.');
    }

    public function toggleStatus(TrendingPrompt $prompt)
    {
        $prompt->update(['is_active' => !$prompt->is_active]);
        
        return redirect()->route('admin.trending-prompts.index')
            ->with('success', 'Trending prompt status updated successfully.');
    }

    public function show(TrendingPrompt $trendingPrompt)
    {
        return view('admin.trending-prompts.show', compact('trendingPrompt'));
    }
} 