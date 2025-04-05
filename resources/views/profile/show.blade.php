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
                        <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
                        <p class="mt-1 text-sm text-gray-500">View your profile information</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
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
                                            <label class="block text-sm font-medium text-gray-700">Name</label>
                                            <div class="mt-1 text-sm text-gray-900">{{ auth()->user()->name }}</div>
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Email</label>
                                            <div class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</div>
                                        </div>

                                        <!-- Member Since -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                            <div class="mt-1 text-sm text-gray-900">{{ auth()->user()->created_at->format('F Y') }}</div>
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Disabled
                                            </span>
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
                                        @if(auth()->user()->preference)
                                            <!-- Role -->
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">Professional Role</h3>
                                                    <p class="text-sm text-gray-500">Your primary role in content creation</p>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ auth()->user()->preference->role->name ?? 'Not Set' }}
                                                </span>
                                            </div>

                                            <!-- Industry -->
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">Industry</h3>
                                                    <p class="text-sm text-gray-500">Your primary industry</p>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ auth()->user()->preference->industry->name ?? 'Not Set' }}
                                                </span>
                                            </div>

                                            <!-- Interests -->
                                            @if(auth()->user()->interests->isNotEmpty())
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">Interests</h3>
                                                    <p class="text-sm text-gray-500">Your content interests</p>
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach(auth()->user()->interests as $interest)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                {{ $interest->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <p class="text-sm text-gray-500">No preferences set yet</p>
                                                <a href="{{ route('profile.edit') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                    Set your preferences
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 