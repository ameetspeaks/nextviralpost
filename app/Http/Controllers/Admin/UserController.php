<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Industry;
use App\Models\Role;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with(['userSubscriptions.subscription'])
            ->latest()
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subscriptions = Subscription::where('is_active', true)->get();
        $industries = Industry::all();
        $roles = Role::all();
        
        return view('admin.users.create', compact('subscriptions', 'industries', 'roles'));
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
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'credits' => 'nullable|integer|min:0',
            'industry_id' => 'nullable|exists:industries,id',
            'role_id' => 'nullable|exists:roles,id',
            'onboarding_completed' => 'boolean',
            'is_superadmin' => 'boolean'
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_superadmin' => $validated['is_superadmin'] ?? false
            ]);

            // Create user preferences
            if (isset($validated['industry_id']) || isset($validated['role_id'])) {
                $user->preferences()->create([
                    'industry_id' => $validated['industry_id'],
                    'role_id' => $validated['role_id'],
                    'onboarding_completed' => $validated['onboarding_completed'] ?? false
                ]);
            }

            // Create user subscription if selected
            if (isset($validated['subscription_id'])) {
                $subscription = Subscription::find($validated['subscription_id']);
                $user->userSubscriptions()->create([
                    'subscription_id' => $validated['subscription_id'],
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays($subscription->duration),
                    'total_credits' => $validated['credits'] ?? $subscription->credits,
                    'remaining_credits' => $validated['credits'] ?? $subscription->credits
                ]);
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
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
        $subscriptions = Subscription::where('is_active', true)->get();
        $industries = Industry::all();
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'subscriptions', 'industries', 'roles'));
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'credits' => 'nullable|integer|min:0',
            'industry_id' => 'nullable|exists:industries,id',
            'role_id' => 'nullable|exists:roles,id',
            'onboarding_completed' => 'boolean',
            'is_superadmin' => 'boolean'
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'is_superadmin' => $validated['is_superadmin'] ?? false
            ]);

            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            // Update or create user preferences
            if (isset($validated['industry_id']) || isset($validated['role_id'])) {
                $user->preferences()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'industry_id' => $validated['industry_id'],
                        'role_id' => $validated['role_id'],
                        'onboarding_completed' => $validated['onboarding_completed'] ?? false
                    ]
                );
            }

            // Update or create user subscription if selected
            if (isset($validated['subscription_id'])) {
                $subscription = Subscription::find($validated['subscription_id']);
                $user->userSubscriptions()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'subscription_id' => $validated['subscription_id'],
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => now()->addDays($subscription->duration),
                        'total_credits' => $validated['credits'] ?? $subscription->credits,
                        'remaining_credits' => $validated['credits'] ?? $subscription->credits
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
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
            'onboarding_completed' => 'boolean'
        ]);

        try {
            $user->preferences()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'industry_id' => $validated['industry_id'],
                    'role_id' => $validated['role_id'],
                    'onboarding_completed' => $validated['onboarding_completed'] ?? false
                ]
            );

            return redirect()->route('admin.users.edit', $user)
                ->with('success', 'User preferences updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update preferences: ' . $e->getMessage());
        }
    }

    public function updateBasic(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        try {
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email']
            ]);

            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            return redirect()->route('admin.users.edit', $user)->with('success', 'Basic information updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update basic information: ' . $e->getMessage());
        }
    }

    public function updateSubscription(Request $request, User $user)
    {
        $validated = $request->validate([
            'subscription_id' => 'nullable|exists:subscriptions,id',
            'credits' => 'nullable|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            if (isset($validated['subscription_id'])) {
                $subscription = Subscription::find($validated['subscription_id']);
                $user->userSubscriptions()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'subscription_id' => $validated['subscription_id'],
                        'status' => 'active',
                        'start_date' => now(),
                        'end_date' => now()->addDays($subscription->duration),
                        'total_credits' => $validated['credits'] ?? $subscription->credits,
                        'remaining_credits' => $validated['credits'] ?? $subscription->credits
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.users.edit', $user)->with('success', 'Subscription information updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update subscription: ' . $e->getMessage());
        }
    }

    public function updateAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_superadmin' => 'boolean'
        ]);

        try {
            $user->update([
                'is_superadmin' => $validated['is_superadmin'] ?? false
            ]);

            return redirect()->route('admin.users.edit', $user)->with('success', 'Admin status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update admin status: ' . $e->getMessage());
        }
    }
}
