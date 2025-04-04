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
                            <h1 class="text-2xl font-semibold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
                            <p class="mt-1 text-sm text-gray-500">Here's what's happening with your posts today.</p>
            </div>
                        <div class="flex items-center space-x-4">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                    </svg>
                                Filter
                            </button>
                            <a href="{{ route('post-generator.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                                Create New Post
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Posts Today -->
                    <div class="bg-white overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-blue-50">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Posts Today</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">0</div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                                                <span class="sr-only">Increased by</span>
                                                0%
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Posts -->
                    <div class="bg-white overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-indigo-50">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Posts</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">0</div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                                <span class="sr-only">Increased by</span>
                                                0%
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Engagement -->
                    <div class="bg-white overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-green-50">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Views</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">0</div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                                <span class="sr-only">Increased by</span>
                                                0%
                                            </div>
                                        </dd>
                                    </dl>
                    </div>
                </div>
            </div>
        </div>

                    <!-- Viral Score -->
                    <div class="bg-white overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-purple-50">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Viral Score</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">0</div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                                </svg>
                                                <span class="sr-only">Increased by</span>
                                                0%
                                            </div>
                                        </dd>
                                    </dl>
            </div>
            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Recent Posts</h2>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" placeholder="Search posts..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <a href="{{ route('my-posts.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                View all posts
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="py-12">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
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
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('post-generator.index') }}" class="group block rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-indigo-50 group-hover:bg-indigo-100 transition-colors duration-200">
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

                        <a href="{{ route('viral-content.index') }}" class="group block rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors duration-200">
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

                        <a href="{{ route('bookmarks.index') }}" class="group block rounded-lg p-6 bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors duration-200">
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
            </main>
        </div>
    </div>
</x-app-layout> 