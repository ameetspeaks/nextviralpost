@extends('layouts.superadmin')

@section('title', 'Create Viral Template')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Create Viral Template</h2>
            <a href="{{ route('admin.viral-templates.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Back to Templates
            </a>
        </div>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.viral-templates.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="post_content" class="block text-sm font-medium text-gray-700">Post Content</label>
                <textarea name="post_content" id="post_content" rows="5" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('post_content') }}</textarea>
                @error('post_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="post_link" class="block text-sm font-medium text-gray-700">Post Link</label>
                <input type="url" name="post_link" id="post_link" value="{{ old('post_link') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('post_link')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="likes" class="block text-sm font-medium text-gray-700">Likes</label>
                    <input type="number" name="likes" id="likes" value="{{ old('likes', 0) }}" min="0" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('likes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="comments" class="block text-sm font-medium text-gray-700">Comments</label>
                    <input type="number" name="comments" id="comments" value="{{ old('comments', 0) }}" min="0" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('comments')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="shares" class="block text-sm font-medium text-gray-700">Shares</label>
                    <input type="number" name="shares" id="shares" value="{{ old('shares', 0) }}" min="0" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('shares')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="post_type_id" class="block text-sm font-medium text-gray-700">Post Type</label>
                    <select name="post_type_id" id="post_type_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Post Type</option>
                        @foreach($postTypes as $postType)
                            <option value="{{ $postType->id }}" {{ old('post_type_id') == $postType->id ? 'selected' : '' }}>
                                {{ $postType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('post_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tone_id" class="block text-sm font-medium text-gray-700">Tone</label>
                    <select name="tone_id" id="tone_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Tone</option>
                        @foreach($tones as $tone)
                            <option value="{{ $tone->id }}" {{ old('tone_id') == $tone->id ? 'selected' : '' }}>
                                {{ $tone->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tone_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.viral-templates.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 