@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('viral-templates.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Templates
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-full" src="{{ $template->user->profile_photo_url }}" alt="{{ $template->user->name }}">
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $template->title }}</h2>
                        <p class="text-sm text-gray-500">Created by {{ $template->user->name }} • {{ $template->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="bookmarkTemplate({{ $template->id }})" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium {{ $template->interactions->where('type', 'bookmark')->count() ? 'text-yellow-700 bg-yellow-100 border-yellow-200' : 'text-gray-700 bg-white hover:bg-gray-50' }}">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                        </svg>
                        {{ $template->interactions->where('type', 'bookmark')->count() ? 'Bookmarked' : 'Bookmark' }}
                    </button>
                    <button onclick="inspireTemplate({{ $template->id }})" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Get Inspired
                    </button>
                </div>
            </div>

            <div class="prose max-w-none mb-6">
                {!! nl2br(e($template->content)) !!}
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="h-5 w-5 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                            </svg>
                            {{ $template->likes }} likes
                        </span>
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="h-5 w-5 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15 8a3 3 0 11-6 0 3 3 0 016 0zM15 8a3 3 0 11-6 0 3 3 0 016 0zM15 8a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $template->views }} views
                        </span>
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="h-5 w-5 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $template->comments_count }} comments
                        </span>
                    </div>
                    <div class="flex items-center">
                        <button class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Share Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function bookmarkTemplate(templateId) {
    fetch(`/viral-templates/${templateId}/bookmark`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}

function inspireTemplate(templateId) {
    fetch(`/viral-templates/${templateId}/inspire`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>
@endpush
@endsection 