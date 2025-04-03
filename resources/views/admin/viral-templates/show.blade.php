@extends('layouts.superadmin')

@section('title', 'View Viral Template')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">View Viral Template</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.viral-templates.edit', $viral_template) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit Template
                </a>
                <a href="{{ route('admin.viral-templates.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back to Templates
                </a>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Username</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $viral_template->username }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Post Content</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $viral_template->post_content }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Post Link</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ $viral_template->post_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                {{ $viral_template->post_link }}
                            </a>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Engagement Metrics</h3>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Likes</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($viral_template->likes) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Comments</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($viral_template->comments) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Shares</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($viral_template->shares) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Associations</h3>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Post Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $viral_template->postType->name ?? 'Not set' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $viral_template->tone->name ?? 'Not set' }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Status Information</h3>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <form action="{{ route('admin.viral-templates.toggle-status', $viral_template) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm font-medium rounded-full {{ $viral_template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $viral_template->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $viral_template->created_at->format('F j, Y, g:i a') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $viral_template->updated_at->format('F j, Y, g:i a') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-200">
            <form action="{{ route('admin.viral-templates.destroy', $viral_template) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Delete Template
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 