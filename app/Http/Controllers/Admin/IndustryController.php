<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryController extends Controller
{
    /**
     * Display a listing of the industries.
     */
    public function index()
    {
        $industries = Industry::latest()->paginate(10);
        return view('admin.industries.index', compact('industries'));
    }

    /**
     * Show the form for creating a new industry.
     */
    public function create()
    {
        return view('admin.industries.create');
    }

    /**
     * Store a newly created industry in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:industries',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Industry::create($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry created successfully.');
    }

    /**
     * Display the specified industry.
     */
    public function show(Industry $industry)
    {
        return view('admin.industries.show', compact('industry'));
    }

    /**
     * Show the form for editing the specified industry.
     */
    public function edit(Industry $industry)
    {
        return view('admin.industries.edit', compact('industry'));
    }

    /**
     * Update the specified industry in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:industries,name,' . $industry->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $industry->update($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry updated successfully.');
    }

    /**
     * Remove the specified industry from storage.
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry deleted successfully.');
    }

    /**
     * Toggle the active status of the specified industry.
     *
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Industry $industry)
    {
        $industry->update(['is_active' => !$industry->is_active]);
        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry status updated successfully.');
    }
}
