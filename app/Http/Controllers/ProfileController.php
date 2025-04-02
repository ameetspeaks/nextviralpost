<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Industry;
use App\Models\Role;
use App\Models\Interest;
use Illuminate\Routing\Controller as BaseController;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user();
        return view('profile.edit', [
            'user' => $user,
            'roles' => Role::where('is_active', true)->get(),
            'industries' => Industry::where('is_active', true)->get(),
            'interests' => Interest::where('is_active', true)->get(),
            'userPreferences' => $user->preference,
            'userInterests' => $user->interests->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        $validated = $request->validated();

        // Update basic info
        $user->full_name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['current_password' => ['The current password is incorrect.']]
                ], 422);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        // Update preferences
        $user->preference()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'role_id' => $validated['role_id'],
                'industry_id' => $validated['industry_id']
            ]
        );

        // Update interests
        $user->interests()->sync($validated['interest_ids']);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
} 