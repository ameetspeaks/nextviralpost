@php
use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between py-4">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Profile Information</h1>
                            <p class="mt-1 text-sm text-gray-500">View your profile information and preferences.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <!-- Basic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Basic Information</h3>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $user->full_name }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $user->email }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Professional Information</h3>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Professional Role</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $userPreferences?->role?->name ?? 'Not specified' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Industry</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $userPreferences?->industry?->name ?? 'Not specified' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interests -->
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Interests</h3>
                            <div class="mt-4">
                                @if($userInterests && count($userInterests) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($interests->whereIn('id', $userInterests) as $interest)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $interest->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No interests selected</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout> 