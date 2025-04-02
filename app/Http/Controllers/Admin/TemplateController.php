<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Industry;
use App\Models\PostType;
use App\Models\Tone;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $templates = Template::with(['industry', 'postType', 'tone'])
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
        $industries = Industry::where('is_active', true)->get();
        $postTypes = PostType::where('is_active', true)->get();
        $tones = Tone::where('is_active', true)->get();
        
        return view('admin.templates.create', compact('industries', 'postTypes', 'tones'));
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry_id' => 'required|exists:industries,id',
            'post_type_id' => 'required|exists:post_types,id',
            'tone_id' => 'required|exists:tones,id',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Template::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\View\View
     */
    public function show(Template $template)
    {
        return view('admin.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\View\View
     */
    public function edit(Template $template)
    {
        $industries = Industry::where('is_active', true)->get();
        $postTypes = PostType::where('is_active', true)->get();
        $tones = Tone::where('is_active', true)->get();
        
        return view('admin.templates.edit', compact('template', 'industries', 'postTypes', 'tones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry_id' => 'required|exists:industries,id',
            'post_type_id' => 'required|exists:post_types,id',
            'tone_id' => 'required|exists:tones,id',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully.');
    }
}
