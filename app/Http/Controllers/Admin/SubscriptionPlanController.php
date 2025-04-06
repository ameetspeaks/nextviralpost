<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();
        return view('admin.subscription-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-plans.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validatePlan($request);
        
        $plan = SubscriptionPlan::create($validated);

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.');
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
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.form', ['plan' => $subscriptionPlan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $this->validatePlan($request, $subscriptionPlan);
        
        $subscriptionPlan->update($validated);

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        // Check if the plan has any active subscriptions
        if ($subscriptionPlan->userSubscriptions()->where('ends_at', '>', now())->exists()) {
            return redirect()
                ->route('admin.subscription-plans.index')
                ->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $subscriptionPlan->delete();

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    protected function validatePlan(Request $request, ?SubscriptionPlan $plan = null): array
    {
        $unique = Rule::unique('subscription_plans', 'slug');
        if ($plan) {
            $unique->ignore($plan);
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $unique],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'credits_per_month' => ['required', 'integer', 'min:0'],
            'max_posts_per_day' => ['required', 'integer', 'min:0'],
            'has_viral_recipe' => ['boolean'],
            'has_analytics' => ['boolean'],
            'has_priority_support' => ['boolean'],
            'badge_color' => ['required', 'string', Rule::in(['gray', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'])],
            'is_active' => ['boolean'],
        ]);
    }
}
