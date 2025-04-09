@extends('layouts.superadmin')

@section('title', 'View Post')

@section('content')
<div class="bg-white shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">View Post</h2>
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Posts
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Post Details</h3>
                    <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">User</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->user->name }}</dd>
                            </div>
                        </div>
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                        </div>
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Post Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->postType->name }}</dd>
                            </div>
                        </div>
                        <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Tone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->tone->name }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Keywords</h3>
                    <div class="mt-2">
                        <div class="text-sm text-gray-900">{{ $post->keywords }}</div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Raw Content</h3>
                    <div class="mt-2">
                        <div class="text-sm text-gray-900">{{ $post->raw_content }}</div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900">Generated Content</h3>
                    <div class="mt-2">
                        <div class="text-sm text-gray-900 whitespace-pre-wrap">{{ $post->generated_content }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 