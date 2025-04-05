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
                        <h1 class="text-2xl font-semibold text-gray-900">Bookmarks</h1>
                        <p class="mt-1 text-sm text-gray-500">Your saved posts and content ideas</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Search bookmarks..." class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <!-- Bookmarks Grid -->
                    <div class="grid grid-cols-3 gap-6">
                        <!-- Empty State (shown when no bookmarks) -->
                        <div class="col-span-3">
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 text-center py-12">
                                <div class="mx-auto w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No bookmarks yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Save interesting posts and content ideas for later.</p>
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

                        <!-- Bookmark Card Template (hidden by default, shown when there are bookmarks) -->
                        <div class="hidden bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">Post Title</h3>
                                        <p class="mt-1 text-sm text-gray-500">Saved on Jan 1, 2024</p>
                                    </div>
                                    <button class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 line-clamp-3">Post content preview goes here...</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            0
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            0
                                        </span>
                                    </div>
                                    <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Post
                                    </button>
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