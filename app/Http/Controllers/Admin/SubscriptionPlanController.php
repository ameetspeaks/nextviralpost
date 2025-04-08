<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('admin.subscription-plans.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'plan_type' => 'required|in:free,paid',
            'duration' => 'required|integer|min:1',
            'credits' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subscription = Subscription::create($request->all());

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return view('admin.subscription-plans.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscription-plans.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'plan_type' => 'required|in:free,paid',
            'duration' => 'required|integer|min:1',
            'credits' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subscription->update($request->all());

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        if ($subscription->userSubscriptions()->exists()) {
            return redirect()->route('admin.subscription-plans.index')
                ->with('error', 'Cannot delete subscription plan that has active users.');
        }

        $subscription->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    /**
     * Toggle the status of the specified subscription plan.
     */
    public function toggleStatus(Subscription $subscription)
    {
        $subscription->update(['is_active' => !$subscription->is_active]);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan status updated successfully.');
    }
}
