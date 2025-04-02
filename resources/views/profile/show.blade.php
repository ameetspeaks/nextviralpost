@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Profile Settings</h1>

    <!-- Profile Form -->
    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="{{ $user->full_name }}" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role_id" name="role_id" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $userPreferences?->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="industry_id" class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <select id="industry_id" name="industry_id" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}" {{ $userPreferences?->industry_id == $industry->id ? 'selected' : '' }}>
                                {{ $industry->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Interests -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Interests</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($interests as $interest)
                    <label class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="interest_ids[]" value="{{ $interest->id }}"
                                {{ in_array($interest->id, $userInterests) ? 'checked' : '' }}
                                disabled
                                class="h-4 w-4 text-gray-400 border-gray-300 rounded cursor-not-allowed">
                        </div>
                        <div class="ml-3 text-sm">
                            <span class="text-gray-700">{{ $interest->name }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" id="current_password" name="current_password" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="new_password" name="new_password" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" disabled
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div id="error-message" class="hidden bg-red-50 text-red-600 p-4 rounded-lg"></div>

        <!-- Success Message -->
        <div id="success-message" class="hidden bg-green-50 text-green-600 p-4 rounded-lg"></div>

        <!-- Submit Button - Hidden since form is uneditable -->
        <div class="flex justify-end hidden">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors flex items-center">
                <span class="loading-spinner hidden mr-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span class="button-text">Save Changes</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Remove form submission handling since the form is uneditable
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
});
</script>
@endpush
@endsection 