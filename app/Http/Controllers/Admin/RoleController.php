<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        Role::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
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
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function toggleStatus(Role $role)
    {
        $role->update(['is_active' => !$role->is_active]);
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role status updated successfully.');
    }

    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="roles.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'name',
                'description',
                'permissions',
                'is_active'
            ]);

            // Add sample data
            fputcsv($file, [
                'Editor',
                'Can edit content but not manage users',
                json_encode(['edit_content' => true, 'manage_users' => false]),
                '1'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

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
                $role = [
                    'name' => $data[0],
                    'description' => $data[1],
                    'permissions' => !empty($data[2]) ? json_decode($data[2], true) : null,
                    'is_active' => !empty($data[3]) ? (bool) $data[3] : true
                ];

                Role::create($role);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Error importing row: " . implode(',', $data) . " - " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Successfully imported {$imported} roles.";
        if (!empty($errors)) {
            $message .= " However, there were some errors: " . implode('; ', $errors);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', $message);
    }
}
