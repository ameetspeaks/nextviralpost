<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interests = Interest::latest()->paginate(10);
        return view('admin.interests.index', compact('interests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.interests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:interests',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        Interest::create($validated);

        return redirect()->route('admin.interests.index')
            ->with('success', 'Interest created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interest $interest)
    {
        return view('admin.interests.edit', compact('interest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interest $interest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:interests,name,' . $interest->id,
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $interest->update($validated);

        return redirect()->route('admin.interests.index')
            ->with('success', 'Interest updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interest $interest)
    {
        $interest->delete();

        return redirect()->route('admin.interests.index')
            ->with('success', 'Interest deleted successfully.');
    }
}
