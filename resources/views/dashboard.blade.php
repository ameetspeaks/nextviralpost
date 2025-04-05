@extends('layouts.app')

@php
use Illuminate\Support\Facades\Auth;
@endphp

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
                        <h1 class="text-2xl font-semibold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="mt-1 text-sm text-gray-500">Here's what's happening with your posts today.</p>
                    </div>
                    <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create New Post
                    </a>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-4 gap-6 mt-8">
                    <!-- Total Posts -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Posts</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalPosts }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Posts Today -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-50">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Posts Today</h3>
                                <p class="text-2xl font-semibold text-gray-900">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Views -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-50">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Views</h3>
                                <p class="text-2xl font-semibold text-gray-900">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Viral Score -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-50">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Viral Score</h3>
                                <p class="text-2xl font-semibold text-gray-900">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Recent Posts</h2>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search posts..." class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <a href="{{ route('my-posts.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                View all posts →
                            </a>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div class="bg-white rounded-lg text-center py-12 border border-gray-200">
                        <div class="mx-auto w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center">
                            <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-sm font-medium text-gray-900">No posts yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first post.</p>
                        <div class="mt-6">
                            <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create New Post
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-3 gap-6">
                        <a href="{{ route('post-generator.index') }}" class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-indigo-50">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Generate New Post</h3>
                                    <p class="mt-1 text-sm text-gray-500">Create viral content with AI</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('viral-content.index') }}" class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-purple-50">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Viral Recipe</h3>
                                    <p class="mt-1 text-sm text-gray-500">Discover trending topics</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('bookmarks.index') }}" class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-lg bg-blue-50">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Saved Posts</h3>
                                    <p class="mt-1 text-sm text-gray-500">View your bookmarks</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 