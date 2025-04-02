<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use Illuminate\Http\Request;

class PostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $postTypes = PostType::latest()->paginate(10);
        return view('admin.post-types.index', compact('postTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.post-types.create');
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
            'name' => 'required|string|max:255|unique:post_types',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PostType::create($validated);

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\View\View
     */
    public function show(PostType $postType)
    {
        return view('admin.post-types.show', compact('postType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\View\View
     */
    public function edit(PostType $postType)
    {
        return view('admin.post-types.edit', compact('postType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PostType $postType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_types,name,' . $postType->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $postType->update($validated);

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PostType $postType)
    {
        $postType->delete();

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type deleted successfully.');
    }
} 