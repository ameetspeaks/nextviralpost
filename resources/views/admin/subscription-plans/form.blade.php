@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">
                {{ isset($plan) ? 'Edit Subscription Plan' : 'Create New Subscription Plan' }}
            </h1>
            <a href="{{ route('admin.subscription-plans.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Plans
            </a>
        </div>

        <div class="mt-8">
            <form action="{{ isset($plan) ? route('admin.subscription-plans.update', $plan) : route('admin.subscription-plans.store') }}" method="POST" class="space-y-8">
                @csrf
                @if(isset($plan))
                    @method('PUT')
                @endif

                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Basic Information -->
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Basic Information</h3>
                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                                        <div class="mt-1">
                                            <input type="text" name="name" id="name" value="{{ old('name', $plan->name ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        </div>
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                        <div class="mt-1">
                                            <input type="text" name="slug" id="slug" value="{{ old('slug', $plan->slug ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        </div>
                                        @error('slug')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <div class="mt-1">
                                            <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $plan->description ?? '') }}</textarea>
                                        </div>
                                        @error('description')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing and Credits -->
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Pricing and Credits</h3>
                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-2">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="price" id="price" value="{{ old('price', $plan->price ?? '') }}" step="0.01" class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        </div>
                                        @error('price')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="credits_per_month" class="block text-sm font-medium text-gray-700">Credits per Month</label>
                                        <div class="mt-1">
                                            <input type="number" name="credits_per_month" id="credits_per_month" value="{{ old('credits_per_month', $plan->credits_per_month ?? '') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        </div>
                                        @error('credits_per_month')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="max_posts_per_day" class="block text-sm font-medium text-gray-700">Max Posts per Day</label>
                                        <div class="mt-1">
                                            <input type="number" name="max_posts_per_day" id="max_posts_per_day" value="{{ old('max_posts_per_day', $plan->max_posts_per_day ?? 0) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        </div>
                                        @error('max_posts_per_day')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Features</h3>
                                <div class="mt-6 space-y-4">
                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input type="checkbox" name="has_viral_recipe" id="has_viral_recipe" value="1" {{ old('has_viral_recipe', $plan->has_viral_recipe ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_viral_recipe" class="font-medium text-gray-700">Viral Recipe Access</label>
                                            <p class="text-gray-500">Access to viral content templates and recipes</p>
                                        </div>
                                    </div>

                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input type="checkbox" name="has_analytics" id="has_analytics" value="1" {{ old('has_analytics', $plan->has_analytics ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_analytics" class="font-medium text-gray-700">Analytics</label>
                                            <p class="text-gray-500">Access to advanced analytics and insights</p>
                                        </div>
                                    </div>

                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input type="checkbox" name="has_priority_support" id="has_priority_support" value="1" {{ old('has_priority_support', $plan->has_priority_support ?? false) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_priority_support" class="font-medium text-gray-700">Priority Support</label>
                                            <p class="text-gray-500">Access to priority customer support</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appearance -->
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Appearance</h3>
                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="badge_color" class="block text-sm font-medium text-gray-700">Badge Color</label>
                                        <div class="mt-1">
                                            <select id="badge_color" name="badge_color" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="gray" {{ old('badge_color', $plan->badge_color ?? '') == 'gray' ? 'selected' : '' }}>Gray</option>
                                                <option value="red" {{ old('badge_color', $plan->badge_color ?? '') == 'red' ? 'selected' : '' }}>Red</option>
                                                <option value="yellow" {{ old('badge_color', $plan->badge_color ?? '') == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                                <option value="green" {{ old('badge_color', $plan->badge_color ?? '') == 'green' ? 'selected' : '' }}>Green</option>
                                                <option value="blue" {{ old('badge_color', $plan->badge_color ?? '') == 'blue' ? 'selected' : '' }}>Blue</option>
                                                <option value="indigo" {{ old('badge_color', $plan->badge_color ?? '') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                                                <option value="purple" {{ old('badge_color', $plan->badge_color ?? '') == 'purple' ? 'selected' : '' }}>Purple</option>
                                                <option value="pink" {{ old('badge_color', $plan->badge_color ?? '') == 'pink' ? 'selected' : '' }}>Pink</option>
                                            </select>
                                        </div>
                                        @error('badge_color')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="mt-1">
                                            <select id="is_active" name="is_active" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="1" {{ old('is_active', $plan->is_active ?? true) ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('is_active', $plan->is_active ?? true) ? '' : 'selected' }}>Inactive</option>
                                            </select>
                                        </div>
                                        @error('is_active')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ isset($plan) ? 'Update Plan' : 'Create Plan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', function() {
        slugInput.value = nameInput.value
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });
});
</script>
@endpush
@endsection 