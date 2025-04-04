@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<div class="flex">
    <!-- Left Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-sm overflow-y-auto">
        <!-- Logo Section -->
        <div class="px-6 py-5 border-b">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="ml-3 text-xl font-semibold text-gray-900">NextViralPost</span>
            </div>
            <p class="mt-1 text-sm text-gray-500">AI Post Generator</p>
        </div>

        <!-- Navigation -->
        <nav class="px-4 py-6">
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('post-generator.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="mr-3 h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Generate Post
                </a>

                <a href="{{ route('viral-content.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Viral Recipe
                </a>

                <a href="{{ route('bookmarks.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    Bookmarks
                </a>

                <a href="{{ route('my-posts.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                    </svg>
                    My Posts
                </a>
            </div>

            <!-- Settings Section -->
            <div class="mt-6 pt-6 border-t">
                <div class="px-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.show') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile Settings
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-64">
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Generate Post</h1>
                        <p class="mt-1 text-sm text-gray-500">Create engaging content using AI</p>
                    </div>
                    <div>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create New Post
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <div class="grid grid-cols-2 gap-8">
                        <!-- Generate Post Column -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                <div>
                                        <h2 class="text-xl font-semibold text-gray-900">Generate Post</h2>
                                        <p class="mt-1 text-sm text-gray-500">Fill in the details to generate your content</p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700">
                                        <svg class="mr-1.5 h-3 w-3 text-indigo-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        AI Powered
                                    </span>
                                </div>
                            </div>

                            <div class="px-6 py-6">
                                <!-- Form Section -->
                                <form id="postGeneratorForm" class="space-y-6">
                                    <!-- Content Type Selection -->
                                    <div class="form-group">
                                        <label for="post_type_id" class="block text-sm font-medium text-gray-700 mb-1">Content Type</label>
                                        <div class="relative">
                                            <select id="post_type_id" name="post_type_id" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg transition duration-150 ease-in-out">
                                                <option value="">Select a content type</option>
                                        @foreach($postTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                </div>

                                    <!-- Tone Selection -->
                                    <div class="form-group">
                                        <label for="tone_id" class="block text-sm font-medium text-gray-700 mb-1">Tone</label>
                                        <div class="relative">
                                            <select id="tone_id" name="tone_id" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg transition duration-150 ease-in-out">
                                        <option value="">Select a tone</option>
                                        @foreach($tones as $tone)
                                            <option value="{{ $tone->id }}">{{ $tone->name }}</option>
                                        @endforeach
                                    </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                </div>

                                    <!-- Keywords Input -->
                                    <div class="form-group">
                                        <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                                        <div class="mt-1 relative rounded-lg shadow-sm">
                                            <input type="text" name="keywords" id="keywords" class="block w-full pl-3 pr-10 py-2.5 sm:text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" placeholder="Enter keywords separated by commas">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                            </div>
                                        </div>
                                </div>

                                    <!-- Raw Content Input -->
                                    <div class="form-group">
                                        <label for="raw_content" class="block text-sm font-medium text-gray-700 mb-1">Raw Content</label>
                                        <div class="mt-1">
                                            <textarea id="raw_content" name="raw_content" rows="4" class="block w-full sm:text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out resize-none" placeholder="Enter your raw content here..."></textarea>
                                        </div>
                                </div>

                                    <!-- Word Limit Slider -->
                                    <div class="form-group">
                                        <label for="word_limit" class="block text-sm font-medium text-gray-700 mb-3">Word Limit</label>
                                        <div class="mt-1">
                                            <input type="range" name="word_limit" id="word_limit" min="50" max="300" step="50" value="50" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                            <div class="flex justify-between mt-2">
                                                <span class="text-xs font-medium text-gray-500">50 words</span>
                                                <span id="word_limit_value" class="text-xs font-medium text-indigo-600">50 words</span>
                                                <span class="text-xs font-medium text-gray-500">300 words</span>
                                            </div>
                                        </div>
                                </div>

                                    <!-- Generate Button -->
                                    <div class="pt-4">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        Generate Post
                                    </button>
                                </form>
                                </div>
                        </div>

                        <!-- Generated Post Column -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900">Generated Post</h2>
                                        <p class="mt-1 text-sm text-gray-500">Preview your generated content</p>
                                                </div>
                                            </div>
                                            </div>

                            <div class="px-6 py-6">
                                <!-- Empty State -->
                                <div id="emptyState" class="text-center py-12">
                                    <div class="mx-auto w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No post generated yet</h3>
                                    <p class="mt-2 text-sm text-gray-500">Fill out the form and click Generate Post to create content.</p>
                                </div>

                                <!-- Generated Content -->
                                <div id="generatedContent" class="hidden">
                                    <!-- LinkedIn-style Card -->
                                    <div class="border rounded-xl bg-white shadow-sm">
                                        <!-- Header with User Info and Bookmark -->
                                        <div class="p-4 border-b">
                                        <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <!-- Website Icon instead of profile photo -->
                                                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                                        <p class="text-xs text-gray-500">NextViralPost</p>
                                                    </div>
                                                </div>
                                                <!-- Bookmark Button -->
                                                <button id="bookmarkButton" type="button" class="inline-flex items-center px-3 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="p-6">
                                            <div id="contentPreview" class="prose max-w-none text-gray-900 text-sm leading-relaxed"></div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="px-6 py-4 bg-gray-50 border-t">
                                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                                <div class="flex items-center space-x-2">
                                                    <button type="button" 
                                                            onclick="copyPost()"
                                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                        </svg>
                                                        Copy
                                                    </button>
                                                    <button type="button" 
                                                            onclick="shareOnLinkedIn()"
                                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                        </svg>
                                                        Share on LinkedIn
                                                    </button>
                                                </div>
                                                <!-- Regenerate Button -->
                                                <button id="regenerateButton" type="button" class="hidden inline-flex items-center px-3 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                                    <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Feedback Section -->
                                        <div class="px-6 py-4 bg-gray-50 border-t">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm text-gray-500">How was this generation?</p>
                                                <div id="feedbackButtons" class="flex items-center space-x-4">
                                                    <button id="positiveFeedback" type="button" class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                                        <svg class="mr-2 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                                        </svg>
                                                        Helpful
                                                    </button>
                                                    <button id="negativeFeedback" type="button" class="inline-flex items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                        <svg class="mr-2 h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"></path>
                                                        </svg>
                                                        Not Helpful
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Loading State -->
                                <div id="loadingState" class="hidden">
                                    <div class="flex flex-col items-center justify-center py-12">
                                        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-indigo-600"></div>
                                        <p class="mt-4 text-sm font-medium text-gray-900">Generating your post...</p>
                                        <p class="mt-2 text-xs text-gray-500">This may take a few seconds</p>
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

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('postGeneratorForm');
    const postTypeSelect = document.getElementById('post_type_id');
    const toneSelect = document.getElementById('tone_id');
    const generateButton = form.querySelector('button[type="submit"]');
        const emptyState = document.getElementById('emptyState');
        const loadingState = document.getElementById('loadingState');
        const generatedContent = document.getElementById('generatedContent');
    const contentPreview = document.getElementById('contentPreview');
    const wordLimitInput = document.getElementById('word_limit');
    const wordLimitValue = document.getElementById('word_limit_value');
    const copyButton = document.getElementById('copyButton');
    const shareButton = document.getElementById('shareButton');
        const bookmarkButton = document.getElementById('bookmarkButton');
        const positiveFeedback = document.getElementById('positiveFeedback');
        const negativeFeedback = document.getElementById('negativeFeedback');
    const regenerateButton = document.getElementById('regenerateButton');
    const feedbackButtons = document.getElementById('feedbackButtons');
    let currentTemplate = null;
    let currentPostId = null;
    let regenerationAttempts = 0;

    // Update word limit value display
    wordLimitInput.addEventListener('input', function() {
        wordLimitValue.textContent = `${this.value} words`;
    });

    // Initialize word limit display
    wordLimitValue.textContent = `${wordLimitInput.value} words`;

    // Function to replace placeholders in template
    function replacePlaceholders(template, data) {
        return template.replace(/\{(\w+)\}/g, (match, key) => data[key] || match);
    }

    // Check template availability when content type or tone changes
    async function checkTemplateAvailability() {
        const postTypeId = postTypeSelect.value;
        const toneId = toneSelect.value;

        if (!postTypeId || !toneId) {
            generateButton.disabled = true;
            return;
        }

        try {
            const response = await fetch('/post-generator/check-template', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    post_type_id: postTypeId,
                    tone_id: toneId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                currentTemplate = data.template;
                generateButton.disabled = false;
            } else {
                currentTemplate = null;
                generateButton.disabled = true;
                alert(data.message || 'No template found for this combination. Please try a different content type or tone.');
            }
        } catch (error) {
            console.error('Error checking template:', error);
            generateButton.disabled = true;
            alert('Error checking template availability. Please try again.');
        }
    }

    // Add event listeners for template checking
    postTypeSelect.addEventListener('change', checkTemplateAvailability);
    toneSelect.addEventListener('change', checkTemplateAvailability);

    // Initial template check
    checkTemplateAvailability();
        
        // Handle form submission
    form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
        if (!currentTemplate) {
            alert('Please select a valid content type and tone combination.');
            return;
        }
            
            // Disable generate button
            generateButton.disabled = true;
        generateButton.classList.add('opacity-50', 'cursor-not-allowed');
            
        try {
            // Get form data
            const formData = {
                post_type_id: postTypeSelect.value,
                tone_id: toneSelect.value,
                keywords: document.getElementById('keywords').value,
                raw_content: document.getElementById('raw_content').value,
                word_limit: wordLimitInput.value,
                prompt: currentTemplate.content
            };
            
            // Send request to generate post
            const response = await fetch('/post-generator/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to generate post');
            }

            // Store current post ID
            currentPostId = result.id;
            regenerationAttempts = result.regeneration_attempts || 0;

            // Show generated content
            contentPreview.textContent = result.generated_content;
                loadingState.classList.add('hidden');
            emptyState.classList.add('hidden');
            generatedContent.classList.remove('hidden');

            // Show feedback buttons
            feedbackButtons.classList.remove('hidden');
            regenerateButton.classList.add('hidden');

            // Setup copy button
            copyButton.addEventListener('click', () => {
                navigator.clipboard.writeText(result.generated_content)
                    .then(() => {
                        const originalText = copyButton.textContent;
                        copyButton.textContent = 'Copied!';
                setTimeout(() => {
                            copyButton.textContent = originalText;
                }, 2000);
            });
        });
        
            // Setup share button
            shareButton.addEventListener('click', () => {
                const text = encodeURIComponent(result.generated_content);
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(window.location.href)}&text=${text}`, '_blank');
            });

            // Setup bookmark button
            bookmarkButton.addEventListener('click', async () => {
                try {
                    const response = await fetch('/post-generator/bookmark/' + result.id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const bookmarkResult = await response.json();
                    if (bookmarkResult.success) {
                        bookmarkButton.querySelector('svg').classList.toggle('text-indigo-600');
                        bookmarkButton.querySelector('svg').classList.toggle('fill-current');
                    }
                } catch (error) {
                    console.error('Error bookmarking post:', error);
                }
            });

        } catch (error) {
            console.error('Error:', error);
            loadingState.classList.add('hidden');
            emptyState.classList.remove('hidden');
            alert(error.message || 'An error occurred while generating the post');
            
            // Re-enable generate button on error
            generateButton.disabled = false;
            generateButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });

    // Handle feedback buttons
    positiveFeedback.addEventListener('click', async () => {
        try {
            const response = await fetch(`/post-generator/feedback/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    feedback: 'positive'
                })
            });

            const result = await response.json();
            if (result.success) {
                feedbackButtons.classList.add('hidden');
                positiveFeedback.classList.add('bg-green-50', 'border-green-500');
            }
        } catch (error) {
            console.error('Error submitting feedback:', error);
        }
    });

    negativeFeedback.addEventListener('click', async () => {
        try {
            const response = await fetch(`/post-generator/feedback/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    feedback: 'negative'
                })
            });

            const result = await response.json();
            if (result.success) {
                feedbackButtons.classList.add('hidden');
                if (regenerationAttempts < 2) {
                    regenerateButton.classList.remove('hidden');
                }
            }
        } catch (error) {
            console.error('Error submitting feedback:', error);
        }
    });

    // Handle regenerate button
    regenerateButton.addEventListener('click', async () => {
        if (regenerationAttempts >= 2) {
            alert('Maximum regeneration attempts reached.');
            return;
        }

        try {
            loadingState.classList.remove('hidden');
            generatedContent.classList.add('hidden');

            const response = await fetch(`/post-generator/regenerate/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();
            if (result.success) {
                currentPostId = result.id;
                regenerationAttempts = result.regeneration_attempts;
                contentPreview.textContent = result.generated_content;
                
                loadingState.classList.add('hidden');
                generatedContent.classList.remove('hidden');
                feedbackButtons.classList.remove('hidden');
                regenerateButton.classList.add('hidden');

                if (regenerationAttempts >= 2) {
                    regenerateButton.classList.add('hidden');
                }
            }
        } catch (error) {
            console.error('Error regenerating post:', error);
            loadingState.classList.add('hidden');
            generatedContent.classList.remove('hidden');
            alert('Error regenerating post. Please try again.');
        }
    });

    function toggleBookmark() {
        const postId = document.querySelector('.bookmark-btn').dataset.postId;
        if (!postId) return;

        fetch(`/bookmarks/${postId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const svg = document.querySelector('.bookmark-btn svg');
                if (data.is_bookmarked) {
                    svg.classList.remove('text-gray-400');
                    svg.classList.add('text-indigo-600');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    svg.classList.remove('text-indigo-600');
                    svg.classList.add('text-gray-400');
                    svg.setAttribute('fill', 'none');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the bookmark');
        });
    }
    });
    </script>
    @endpush