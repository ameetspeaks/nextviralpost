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

    /**
     * Toggle the active status of the specified template.
     *
     * @param  \App\Models\PromptTemplate  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(PromptTemplate $template)
    {
        $template->update(['is_active' => !$template->is_active]);
        return redirect()->route('admin.templates.index')
            ->with('success', 'Template status updated successfully.');
    }

    /**
     * Export templates as CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="templates.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'title',
                'content',
                'post_type_id',
                'tone_id',
                'category',
                'post_goal',
                'virality_factor',
                'is_active'
            ]);

            // Add sample data
            fputcsv($file, [
                'Example Template',
                'Create an engaging post about {topic} that will encourage audience participation.',
                '1',
                '1',
                'Engagement',
                'Increase audience interaction',
                'Thought-provoking questions',
                '1'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import templates from CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Skip header row
        fgetcsv($handle);
        
        $imported = 0;
        $errors = [];

        while (($data = fgetcsv($handle)) !== false) {
            try {
                $template = [
                    'title' => $data[0],
                    'content' => $data[1],
                    'post_type_id' => !empty($data[2]) ? (int) $data[2] : null,
                    'tone_id' => !empty($data[3]) ? (int) $data[3] : null,
                    'category' => $data[4],
                    'post_goal' => $data[5],
                    'virality_factor' => $data[6],
                    'is_active' => !empty($data[7]) ? (bool) $data[7] : true,
                    'slug' => Str::slug($data[0]),
                    'version' => 1
                ];

                PromptTemplate::create($template);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Error importing row: " . implode(',', $data) . " - " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Successfully imported {$imported} templates.";
        if (!empty($errors)) {
            $message .= " However, there were some errors: " . implode('; ', $errors);
        }

        return redirect()->route('admin.templates.index')
            ->with('success', $message);
    }
}
