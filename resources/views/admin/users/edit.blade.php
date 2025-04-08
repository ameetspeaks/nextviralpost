@extends('layouts.superadmin')

@section('title', 'Edit User')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Back to List
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Basic Information Form -->
        <form action="{{ route('admin.users.update.basic', $user) }}" method="POST" class="mb-8">
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('full_name') border-red-500 @enderror">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Basic Information
                </button>
            </div>
        </form>

        <!-- Subscription Information Form -->
        <form action="{{ route('admin.users.update.subscription', $user) }}" method="POST" class="mb-8">
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="subscription_id" class="block text-sm font-medium text-gray-700">Subscription Plan</label>
                        <select name="subscription_id" id="subscription_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a Plan</option>
                            @foreach($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}" 
                                    data-credits="{{ $subscription->credits }}"
                                    {{ old('subscription_id', $user->userSubscriptions->first()->subscription_id ?? '') == $subscription->id ? 'selected' : '' }}>
                                    {{ $subscription->name }} ({{ $subscription->credits }} credits)
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="credits" class="block text-sm font-medium text-gray-700">Credits</label>
                        <input type="number" name="credits" id="credits" value="{{ old('credits', $user->userSubscriptions->first()->remaining_credits ?? 0) }}" min="0"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('credits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($user->userSubscriptions->isNotEmpty())
                    <div class="mt-4 p-4 bg-gray-50 rounded-md">
                        <h4 class="text-sm font-medium text-gray-700">Current Subscription Details</h4>
                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="ml-2 font-medium">{{ $user->userSubscriptions->first()->status }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Start Date:</span>
                                <span class="ml-2 font-medium">{{ $user->userSubscriptions->first()->start_date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">End Date:</span>
                                <span class="ml-2 font-medium">{{ $user->userSubscriptions->first()->end_date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Total Credits:</span>
                                <span class="ml-2 font-medium">{{ $user->userSubscriptions->first()->total_credits }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Subscription Information
                </button>
            </div>
        </form>

        <!-- User Preferences Form -->
        <form action="{{ route('admin.users.preferences.update', $user) }}" method="POST" class="mb-8">
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">User Preferences</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="industry_id" class="block text-sm font-medium text-gray-700">Industry</label>
                        <select name="industry_id" id="industry_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Industry</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" {{ old('industry_id', $user->preferences->industry_id ?? '') == $industry->id ? 'selected' : '' }}>
                                    {{ $industry->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('industry_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role_id" id="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->preferences->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="onboarding_completed" id="onboarding_completed" value="1" 
                            {{ old('onboarding_completed', $user->preferences->onboarding_completed ?? false) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="onboarding_completed" class="ml-2 block text-sm text-gray-900">
                            Onboarding Completed
                        </label>
                    </div>
                    @error('onboarding_completed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save User Preferences
                </button>
            </div>
        </form>

        <!-- Admin Status Form -->
        <form action="{{ route('admin.users.update.admin', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Status</h3>
                <div class="flex items-center">
                    <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" {{ old('is_superadmin', $user->is_superadmin) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_superadmin" class="ml-2 block text-sm text-gray-700">Make this user an admin</label>
                </div>
                @error('is_superadmin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Admin Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subscriptionSelect = document.getElementById('subscription_id');
        const creditsInput = document.getElementById('credits');

        // Update credits when subscription changes
        subscriptionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                creditsInput.value = selectedOption.getAttribute('data-credits');
            } else {
                creditsInput.value = '';
            }
        });

        // Initialize credits if a subscription is already selected
        if (subscriptionSelect.value) {
            const selectedOption = subscriptionSelect.options[subscriptionSelect.selectedIndex];
            creditsInput.value = selectedOption.getAttribute('data-credits');
        }
    });
</script>
@endpush 