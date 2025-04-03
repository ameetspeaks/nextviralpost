@extends('layouts.superadmin')

@section('title', 'View Post Type')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Post Type Details</h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.post-types.edit', $postType) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit
                </a>
                <a href="{{ route('admin.post-types.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Name</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $postType->name }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Description</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $postType->description }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Status</h3>
                <div class="mt-1">
                    <form action="{{ route('admin.post-types.toggle-status', $postType) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $postType->is_active ? 'bg-indigo-600' : 'bg-gray-200' }}" role="switch" aria-checked="{{ $postType->is_active ? 'true' : 'false' }}">
                            <span class="sr-only">Toggle status</span>
                            <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $postType->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                        <span class="ml-2 text-sm {{ $postType->is_active ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $postType->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </form>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Created At</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $postType->created_at->format('M d, Y H:i:s') }}</p>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Last Updated</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $postType->updated_at->format('M d, Y H:i:s') }}</p>
            </div>
        </div>

        <div class="mt-6">
            <form action="{{ route('admin.post-types.destroy', $postType) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to delete this post type?')">
                    Delete Post Type
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 