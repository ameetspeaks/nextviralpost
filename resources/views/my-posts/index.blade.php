@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Main Content Area -->
    <main class="flex-1 ml-56">
        <div class="py-6">
            <div class="max-w-3xl mx-auto px-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">My Posts</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your generated content</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search posts..." class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create New Post
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <form action="{{ route('my-posts.index') }}" method="GET" class="mt-4">
                    <div class="flex items-center space-x-4">
                        <select name="source" onchange="this.form.submit()" class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                            <option value="">All Sources</option>
                            <option value="generated" {{ request('source') === 'generated' ? 'selected' : '' }}>Generated Posts</option>
                            <option value="repurposed" {{ request('source') === 'repurposed' ? 'selected' : '' }}>Repurposed Content</option>
                        </select>
                        <select name="type" onchange="this.form.submit()" class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                            <option value="">All Types</option>
                            <option value="linkedin" {{ request('type') === 'linkedin' ? 'selected' : '' }}>LinkedIn Posts</option>
                            <option value="twitter" {{ request('type') === 'twitter' ? 'selected' : '' }}>Twitter Posts</option>
                            <option value="blog" {{ request('type') === 'blog' ? 'selected' : '' }}>Blog Posts</option>
                        </select>
                        <select name="period" onchange="this.form.submit()" class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                            <option value="">All Time</option>
                            <option value="7" {{ request('period') === '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ request('period') === '30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ request('period') === '90' ? 'selected' : '' }}>Last 90 Days</option>
                        </select>
                    </div>
                </form>

                <!-- Main Content -->
                <div class="mt-8">
                    <!-- Posts List -->
                    <div class="space-y-6">
                        @forelse($posts as $post)
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                <!-- Post Header -->
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-12 w-12 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ auth()->user()->headline ?? 'Content Creator' }}</p>
                                                <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button class="text-gray-400 hover:text-gray-500">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Post Content -->
                                <div class="p-6 flex-grow">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->source === 'repurposed' ? 'bg-purple-50 text-purple-700' : 'bg-indigo-50 text-indigo-700' }}">
                                            {{ ucfirst($post->source) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-800 text-base leading-relaxed">{{ $post->generated_content }}</p>
                                </div>
                                
                                <!-- Post Actions -->
                                <div class="px-6 py-4 border-t border-gray-200 mt-auto">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-6">
                                            <button class="flex items-center text-gray-500 hover:text-gray-700">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                                </svg>
                                                Like
                                            </button>
                                            <button class="flex items-center text-gray-500 hover:text-gray-700">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                Comment
                                            </button>
                                            <button class="flex items-center text-gray-500 hover:text-gray-700">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                </svg>
                                                Share
                                            </button>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="copyToClipboard('{{ $post->id }}')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 text-center py-12">
                                <div class="mx-auto w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No posts yet</h3>
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
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="mt-6">
                            {{ $posts->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 