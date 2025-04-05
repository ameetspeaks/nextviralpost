@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Main Content Area -->
    <main class="flex-1 ml-56">
        <div class="py-6">
            <div class="max-w-[1600px] mx-auto px-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Edit Profile</h1>
                        <p class="mt-1 text-sm text-gray-500">Update your profile information</p>
                    </div>
                    <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Profile
                    </a>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-3 gap-6">
                            <!-- Profile Information -->
                            <div class="col-span-2 space-y-6">
                                <!-- Basic Information Card -->
                                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-6">
                                            <!-- Profile Photo -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                                                <div class="mt-2">
                                                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Name -->
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('name')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('email')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Security -->
                                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">Account Security</h2>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                                                    <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                                                </div>
                                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Enable
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Preferences -->
                            <div class="space-y-6">
                                <!-- User Preferences Card -->
                                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">User Preferences</h2>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <!-- Role -->
                                            <div>
                                                <label for="role_id" class="block text-sm font-medium text-gray-700">Professional Role</label>
                                                <select name="role_id" id="role_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Select a role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('role_id', auth()->user()->preference?->role_id) == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Industry -->
                                            <div>
                                                <label for="industry_id" class="block text-sm font-medium text-gray-700">Industry</label>
                                                <select name="industry_id" id="industry_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Select an industry</option>
                                                    @foreach($industries as $industry)
                                                        <option value="{{ $industry->id }}" {{ old('industry_id', auth()->user()->preference?->industry_id) == $industry->id ? 'selected' : '' }}>
                                                            {{ $industry->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('industry_id')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Interests -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Interests</label>
                                                <div class="mt-2 space-y-2">
                                                    @foreach($interests as $interest)
                                                        <div class="flex items-center">
                                                            <input type="checkbox" name="interest_ids[]" id="interest_{{ $interest->id }}" value="{{ $interest->id }}" 
                                                                {{ in_array($interest->id, old('interest_ids', auth()->user()->interests->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                            <label for="interest_{{ $interest->id }}" class="ml-3 text-sm text-gray-700">{{ $interest->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('interest_ids')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                    <div class="p-6">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 