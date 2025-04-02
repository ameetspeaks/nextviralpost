<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromptTemplate;
use App\Models\PostType;
use App\Models\PostTone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $templates = PromptTemplate::with(['postType', 'tone'])
            ->latest()
            ->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $postTypes = PostType::where('is_active', true)->get();
        $tones = PostTone::where('is_active', true)->get();
        return view('admin.templates.create', compact('postTypes', 'tones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type_id' => 'required|exists:post_types,id',
            'tone_id' => 'required|exists:post_tones,id',
            'category' => 'required|string|max:255',
            'post_goal' => 'required|string|max:255',
            'virality_factor' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['version'] = 1;

        PromptTemplate::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromptTemplate  $template
     * @return \Illuminate\View\View
     */
    public function show(PromptTemplate $template)
    {
        return view('admin.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PromptTemplate  $template
     * @return \Illuminate\View\View
     */
    public function edit(PromptTemplate $template)
    {
        $postTypes = PostType::where('is_active', true)->get();
        $tones = PostTone::where('is_active', true)->get();
        return view('admin.templates.edit', compact('template', 'postTypes', 'tones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromptTemplate  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PromptTemplate $template)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type_id' => 'required|exists:post_types,id',
            'tone_id' => 'required|exists:post_tones,id',
            'category' => 'required|string|max:255',
            'post_goal' => 'required|string|max:255',
            'virality_factor' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['version'] = $template->version + 1;

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromptTemplate  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PromptTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully.');
    }
}
