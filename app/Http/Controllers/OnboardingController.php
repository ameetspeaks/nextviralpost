<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Interest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class OnboardingController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        
        // If user has already completed onboarding, redirect to dashboard
        if ($user->hasCompletedOnboarding()) {
            return redirect()->route('dashboard');
        }

        return view('auth.onboarding', [
            'roles' => Role::where('is_active', true)
                          ->whereNotIn('name', ['Admin', 'Super Admin'])
                          ->get(),
            'industries' => Industry::where('is_active', true)->get(),
            'interests' => Interest::where('is_active', true)->get(),
            'userPreferences' => $user->preference,
            'userInterests' => $user->interests->pluck('id')->toArray()
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'industry_id' => 'required|exists:industries,id',
            'interest_ids' => 'nullable|array',
            'interest_ids.*' => 'exists:interests,id',
        ]);

        try {
            // Update or create user preferences
            $user->preference()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'role_id' => $validated['role_id'],
                    'industry_id' => $validated['industry_id'],
                    'onboarding_completed' => true,
                ]
            );

            // Sync user interests if provided
            if (!empty($validated['interest_ids'])) {
                $user->interests()->sync($validated['interest_ids']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Onboarding completed successfully!',
                'redirect' => route('dashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your preferences. Please try again.'
            ], 500);
        }
    }
} 