<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostTone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToneController extends Controller
{
    /**
     * Display a listing of the tones.
     */
    public function index()
    {
        $tones = PostTone::latest()->paginate(10);
        return view('admin.tones.index', compact('tones'));
    }

    /**
     * Show the form for creating a new tone.
     */
    public function create()
    {
        return view('admin.tones.create');
    }

    /**
     * Store a newly created tone in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_tones',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        PostTone::create($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone created successfully.');
    }

    /**
     * Display the specified tone.
     */
    public function show(PostTone $tone)
    {
        return view('admin.tones.show', compact('tone'));
    }

    /**
     * Show the form for editing the specified tone.
     */
    public function edit(PostTone $tone)
    {
        return view('admin.tones.edit', compact('tone'));
    }

    /**
     * Update the specified tone in storage.
     */
    public function update(Request $request, PostTone $tone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_tones,name,' . $tone->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $tone->update($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone updated successfully.');
    }

    /**
     * Remove the specified tone from storage.
     */
    public function destroy(PostTone $tone)
    {
        $tone->delete();

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone deleted successfully.');
    }

    /**
     * Toggle the active status of the specified tone.
     *
     * @param  \App\Models\PostTone  $tone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(PostTone $tone)
    {
        $tone->update(['is_active' => !$tone->is_active]);
        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone status updated successfully.');
    }
} 