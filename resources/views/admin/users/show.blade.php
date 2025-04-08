@extends('layouts.superadmin')

@section('title', 'View User')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">User Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_superadmin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user->is_superadmin ? 'Super Admin' : 'User' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at instanceof \Carbon\Carbon ? $user->created_at->format('M d, Y H:i:s') : $user->created_at }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at instanceof \Carbon\Carbon ? $user->updated_at->format('M d, Y H:i:s') : $user->updated_at }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Verified At</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($user->email_verified_at)
                                {{ $user->email_verified_at instanceof \Carbon\Carbon ? $user->email_verified_at->format('M d, Y H:i:s') : $user->email_verified_at }}
                            @else
                                Not verified
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription Information</h3>
            @if($user->userSubscriptions->isNotEmpty())
                @php
                    $activeSubscription = $user->userSubscriptions->first();
                @endphp
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">Current Plan</h4>
                            <p class="text-sm text-gray-600">{{ $activeSubscription->subscription->name }}</p>
                            <p class="text-sm text-gray-600">Credits: {{ $activeSubscription->credits_remaining }}</p>
                        </div>
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">Subscription Details</h4>
                            <p class="text-sm text-gray-600">Started: {{ $activeSubscription->start_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-600">Expires: {{ $activeSubscription->end_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-600">Status: 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activeSubscription->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $activeSubscription->is_active ? 'Active' : 'Expired' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.subscription-plans.edit', $activeSubscription->subscription) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View Plan Details
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No active subscription found for this user.
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('admin.subscription-plans.index') }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-600">
                                    Assign a Subscription Plan <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">User Preferences</h3>
            @if(!$user->preferences)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No preferences set for this user.
                            </p>
                            <form action="{{ route('admin.users.preferences.store', $user) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-yellow-700 hover:text-yellow-600">
                                    Initialize Preferences <span aria-hidden="true">&rarr;</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('admin.users.preferences.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="industry_id" class="block text-sm font-medium text-gray-700">Industry</label>
                            <select name="industry_id" id="industry_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Industry</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}" {{ $user->preferences->industry_id == $industry->id ? 'selected' : '' }}>
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
                                    <option value="{{ $role->id }}" {{ $user->preferences->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" name="onboarding_completed" id="onboarding_completed" value="1" 
                                {{ $user->preferences->onboarding_completed ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="onboarding_completed" class="ml-2 block text-sm text-gray-900">
                                Onboarding Completed
                            </label>
                        </div>
                        @error('onboarding_completed')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Update Preferences
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <div class="mt-8 pt-8 border-t border-gray-200">
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex justify-end">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    Delete User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 