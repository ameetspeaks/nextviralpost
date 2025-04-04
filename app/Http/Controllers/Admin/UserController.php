<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Industry;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_superadmin' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_superadmin'] = $request->has('is_superadmin');

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $industries = Industry::where('is_active', true)->get();
        $roles = Role::where('is_active', true)
                    ->when(!auth()->user()->is_superadmin, function($query) {
                        return $query->where('name', '!=', 'Super Admin');
                    })
                    ->get();
        return view('admin.users.show', compact('user', 'industries', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_superadmin' => 'boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_superadmin'] = $request->has('is_superadmin');

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Prevent deleting the last superadmin
        if ($user->is_superadmin && User::where('is_superadmin', true)->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete the last superadmin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Store user preferences.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePreferences(User $user)
    {
        $user->preference()->create([
            'industry_id' => null,
            'role_id' => null,
            'onboarding_completed' => false,
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User preferences initialized successfully.');
    }

    /**
     * Update user preferences.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePreferences(Request $request, User $user)
    {
        $validated = $request->validate([
            'industry_id' => 'nullable|exists:industries,id',
            'role_id' => 'nullable|exists:roles,id',
            'onboarding_completed' => 'boolean',
        ]);

        $user->preference()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User preferences updated successfully.');
    }
}
