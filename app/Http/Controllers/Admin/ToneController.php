<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostTone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tones = PostTone::latest()->paginate(10);
        return view('admin.tones.index', compact('tones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tones.create');
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
            'name' => 'required|string|max:255|unique:post_tones',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        PostTone::create($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostTone  $tone
     * @return \Illuminate\View\View
     */
    public function show(PostTone $tone)
    {
        return view('admin.tones.show', compact('tone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostTone  $tone
     * @return \Illuminate\View\View
     */
    public function edit(PostTone $tone)
    {
        return view('admin.tones.edit', compact('tone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostTone  $tone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PostTone $tone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_tones,name,' . $tone->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $tone->update($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostTone  $tone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PostTone $tone)
    {
        $tone->delete();
        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone deleted successfully.');
    }
} 