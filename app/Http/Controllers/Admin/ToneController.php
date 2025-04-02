<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tone;
use Illuminate\Http\Request;

class ToneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tones = Tone::latest()->paginate(10);
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
            'name' => 'required|string|max:255|unique:tones',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Tone::create($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tone  $tone
     * @return \Illuminate\View\View
     */
    public function show(Tone $tone)
    {
        return view('admin.tones.show', compact('tone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tone  $tone
     * @return \Illuminate\View\View
     */
    public function edit(Tone $tone)
    {
        return view('admin.tones.edit', compact('tone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tone  $tone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tone $tone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tones,name,' . $tone->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $tone->update($validated);

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tone  $tone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tone $tone)
    {
        $tone->delete();

        return redirect()->route('admin.tones.index')
            ->with('success', 'Tone deleted successfully.');
    }
} 