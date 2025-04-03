<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViralTemplate;
use App\Models\PostType;
use App\Models\PostTone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ViralTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $viralTemplates = ViralTemplate::with(['postType', 'tone'])
            ->latest()
            ->paginate(10);
        return view('admin.viral-templates.index', compact('viralTemplates'));
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
        return view('admin.viral-templates.create', compact('postTypes', 'tones'));
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
            'username' => 'required|string|max:255',
            'post_content' => 'required|string',
            'post_link' => 'nullable|url',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'post_type_id' => 'nullable|exists:post_types,id',
            'tone_id' => 'nullable|exists:post_tones,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        ViralTemplate::create($validated);

        return redirect()->route('admin.viral-templates.index')
            ->with('success', 'Viral template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ViralTemplate  $viral_template
     * @return \Illuminate\View\View
     */
    public function show(ViralTemplate $viral_template)
    {
        return view('admin.viral-templates.show', compact('viral_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ViralTemplate  $viral_template
     * @return \Illuminate\View\View
     */
    public function edit(ViralTemplate $viral_template)
    {
        $postTypes = PostType::where('is_active', true)->get();
        $tones = PostTone::where('is_active', true)->get();
        return view('admin.viral-templates.edit', compact('viral_template', 'postTypes', 'tones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ViralTemplate  $viral_template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ViralTemplate $viral_template)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'post_content' => 'required|string',
            'post_link' => 'nullable|url',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
            'post_type_id' => 'nullable|exists:post_types,id',
            'tone_id' => 'nullable|exists:post_tones,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $viral_template->update($validated);

        return redirect()->route('admin.viral-templates.index')
            ->with('success', 'Viral template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ViralTemplate  $viral_template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ViralTemplate $viral_template)
    {
        $viral_template->delete();

        return redirect()->route('admin.viral-templates.index')
            ->with('success', 'Viral template deleted successfully.');
    }

    /**
     * Toggle the active status of the template.
     *
     * @param  \App\Models\ViralTemplate  $viral_template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(ViralTemplate $viral_template)
    {
        $viral_template->update(['is_active' => !$viral_template->is_active]);

        return redirect()->route('admin.viral-templates.index')
            ->with('success', 'Viral template status updated successfully.');
    }

    /**
     * Export viral templates as CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="viral-templates.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'username',
                'post_content',
                'post_link',
                'likes',
                'comments',
                'shares',
                'post_type_id',
                'tone_id',
                'is_active',
                'date_posted'
            ]);

            // Add sample data
            fputcsv($file, [
                'example_user',
                'This is an example post content',
                'https://example.com/post',
                '100',
                '10',
                '5',
                '1',
                '1',
                '1',
                now()->format('Y-m-d H:i:s')
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import viral templates from CSV.
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
                    'username' => $data[0],
                    'post_content' => $data[1],
                    'post_link' => $data[2],
                    'likes' => (int) $data[3],
                    'comments' => (int) $data[4],
                    'shares' => (int) $data[5],
                    'post_type_id' => !empty($data[6]) ? (int) $data[6] : null,
                    'tone_id' => !empty($data[7]) ? (int) $data[7] : null,
                    'is_active' => !empty($data[8]) ? (bool) $data[8] : true,
                    'date_posted' => !empty($data[9]) ? \Carbon\Carbon::parse($data[9]) : now()
                ];

                ViralTemplate::create($template);
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

        return redirect()->route('admin.viral-templates.index')
            ->with('success', $message);
    }
} 