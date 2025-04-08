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
            'Content-Disposition' => 'attachment; filename="templates_' . date('Y-m-d') . '.csv"',
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
                'is_active',
                'version',
                'created_at',
                'updated_at'
            ]);

            // Get all templates
            $templates = PromptTemplate::with(['postType', 'tone'])->get();

            foreach ($templates as $template) {
                fputcsv($file, [
                    $template->title,
                    $template->content,
                    $template->post_type_id,
                    $template->tone_id,
                    $template->category,
                    $template->post_goal,
                    $template->virality_factor,
                    $template->is_active ? '1' : '0',
                    $template->version,
                    $template->created_at,
                    $template->updated_at
                ]);
            }

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
            'file' => 'required|file|mimes:csv,txt',
            'update_existing' => 'boolean'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Skip header row
        fgetcsv($handle);
        
        $imported = 0;
        $updated = 0;
        $errors = [];
        $emptyRows = 0;
        $updateExisting = $request->boolean('update_existing', true); // Default to true for updates
        $rowNumber = 1; // Start from 1 since we skipped header

        while (($data = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            // Skip empty rows
            if (empty(array_filter($data))) {
                $emptyRows++;
                continue;
            }

            try {
                // Validate required fields
                if (empty($data[0]) || empty($data[1])) {
                    throw new \Exception("Row {$rowNumber}: Title and content are required fields");
                }

                // Clean and validate post_type_id and tone_id
                $postTypeId = !empty($data[2]) ? (int) $data[2] : null;
                $toneId = !empty($data[3]) ? (int) $data[3] : null;

                // Validate post_type_id and tone_id exist if provided
                if ($postTypeId && !PostType::where('id', $postTypeId)->exists()) {
                    throw new \Exception("Row {$rowNumber}: Invalid post_type_id");
                }
                if ($toneId && !PostTone::where('id', $toneId)->exists()) {
                    throw new \Exception("Row {$rowNumber}: Invalid tone_id");
                }

                $templateData = [
                    'title' => trim($data[0]),
                    'content' => trim($data[1]),
                    'post_type_id' => $postTypeId,
                    'tone_id' => $toneId,
                    'category' => !empty($data[4]) ? trim($data[4]) : null,
                    'post_goal' => !empty($data[5]) ? trim($data[5]) : null,
                    'virality_factor' => !empty($data[6]) ? trim($data[6]) : null,
                    'is_active' => !empty($data[7]) ? (bool) $data[7] : true,
                    'slug' => Str::slug(trim($data[0])),
                    'version' => !empty($data[8]) ? (int) $data[8] : 1
                ];

                // Check for existing template with same post_type_id and tone_id
                $existingTemplate = PromptTemplate::where('post_type_id', $postTypeId)
                    ->where('tone_id', $toneId)
                    ->first();

                if ($existingTemplate) {
                    // Update existing template
                    $existingTemplate->update($templateData);
                    $updated++;
                } else {
                    // Create new template
                    PromptTemplate::create($templateData);
                    $imported++;
                }
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Import Summary:\n";
        $message .= "- Successfully imported: {$imported} templates\n";
        $message .= "- Updated: {$updated} existing templates\n";
        if ($emptyRows > 0) {
            $message .= "- Skipped: {$emptyRows} empty rows\n";
        }
        if (!empty($errors)) {
            $message .= "\nErrors encountered:\n" . implode("\n", $errors);
        }

        return redirect()->route('admin.templates.index')
            ->with('success', $message);
    }
}
