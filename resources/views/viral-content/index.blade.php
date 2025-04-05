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
                        <h1 class="text-2xl font-semibold text-gray-900">Viral Content Templates</h1>
                        <p class="mt-1 text-sm text-gray-500">Discover and repurpose viral content templates</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search templates..." class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <select class="block w-40 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                                <option value="">All Types</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="twitter">Twitter</option>
                                <option value="blog">Blog</option>
                            </select>
                            <select class="block w-40 pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                                <option value="">All Tones</option>
                                <option value="professional">Professional</option>
                                <option value="casual">Casual</option>
                                <option value="humorous">Humorous</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-4 gap-6 mt-8">
                    <!-- Total Templates -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Templates</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $viralTemplates->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Repurposes -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-50">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Repurposes</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $viralTemplates->sum('repurpose_count') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Average Engagement -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-50">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Avg. Engagement</h3>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($viralTemplates->avg(function($template) {
                                        return ($template->likes + $template->comments + $template->shares) / 3;
                                    }), 0) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Templates -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-50">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Active Templates</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $viralTemplates->where('is_active', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Templates Grid -->
                <div class="mt-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($viralTemplates as $template)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-600 font-medium">{{ substr($template->username, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $template->username }}</p>
                                                <p class="text-sm text-gray-500">{{ $template->date_posted->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="toggleBookmark({{ $template->id }})" class="p-2 hover:bg-gray-100 rounded-full" id="bookmark-button-{{ $template->id }}">
                                                <svg class="w-5 h-5 {{ $template->isBookmarkedBy(Auth::user()) ? 'text-yellow-500 fill-current' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 whitespace-pre-wrap">{{ $template->post_content }}</p>
                                    </div>

                                    @if($template->post_link)
                                        <div class="mt-4">
                                            <a href="{{ $template->post_link }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-500">View Original Post</a>
                                        </div>
                                    @endif

                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                {{ $template->likes }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                {{ $template->comments }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                </svg>
                                                {{ $template->shares }}
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            {{ $template->repurpose_count }}
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <a href="{{ route('viral-content.show', $template) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Use Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
function toggleBookmark(templateId) {
    fetch(`/viral-content/${templateId}/bookmark`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const button = document.querySelector(`#bookmark-button-${templateId} svg`);
        if (data.is_bookmarked) {
            button.classList.remove('text-gray-400');
            button.classList.add('text-yellow-500', 'fill-current');
        } else {
            button.classList.remove('text-yellow-500', 'fill-current');
            button.classList.add('text-gray-400');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection 