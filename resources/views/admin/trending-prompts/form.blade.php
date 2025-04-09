@extends('layouts.superadmin')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ isset($trendingPrompt) ? 'Edit Trending Prompt' : 'Create Trending Prompt' }}
            </h2>
        </div>

        <div class="p-6">
            <form action="{{ isset($trendingPrompt) 
                ? route('admin.trending-prompts.update', $trendingPrompt) 
                : route('admin.trending-prompts.store') }}" 
                  method="POST">
                @csrf
                @if(isset($trendingPrompt))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $trendingPrompt->title ?? '') }}" 
                           required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" 
                              id="description" 
                              name="description" 
                              rows="3" 
                              required>{{ old('description', $trendingPrompt->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="prompt_template" class="block text-sm font-medium text-gray-700">Prompt Template</label>
                    <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('prompt_template') border-red-500 @enderror" 
                              id="prompt_template" 
                              name="prompt_template" 
                              rows="5" 
                              required>{{ old('prompt_template', $trendingPrompt->prompt_template ?? '') }}</textarea>
                    <small class="text-gray-500">Use placeholders in square brackets like [Your Name] for user input</small>
                    @error('prompt_template')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('requirements') border-red-500 @enderror" 
                            id="requirements" 
                            name="requirements[]" 
                            multiple>
                        <option value="image" {{ in_array('image', old('requirements', $trendingPrompt->requirements ?? [])) ? 'selected' : '' }}>
                            Image Upload
                        </option>
                        <option value="video" {{ in_array('video', old('requirements', $trendingPrompt->requirements ?? [])) ? 'selected' : '' }}>
                            Video Upload
                        </option>
                    </select>
                    @error('requirements')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="llm_model" class="block text-sm font-medium text-gray-700">LLM Model</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('llm_model') border-red-500 @enderror" 
                            id="llm_model" 
                            name="llm_model" 
                            required>
                        <option value="gpt-4" {{ old('llm_model', $trendingPrompt->llm_model ?? '') == 'gpt-4' ? 'selected' : '' }}>
                            GPT-4
                        </option>
                        <option value="gpt-3.5-turbo" {{ old('llm_model', $trendingPrompt->llm_model ?? '') == 'gpt-3.5-turbo' ? 'selected' : '' }}>
                            GPT-3.5 Turbo
                        </option>
                    </select>
                    @error('llm_model')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded @error('is_paid') border-red-500 @enderror" 
                               id="is_paid" 
                               name="is_paid" 
                               value="1" 
                               {{ old('is_paid', $trendingPrompt->is_paid ?? false) ? 'checked' : '' }}>
                        <label for="is_paid" class="ml-2 block text-sm text-gray-900">Paid Prompt</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="free_user_limit" class="block text-sm font-medium text-gray-700">Free User Limit</label>
                    <input type="number" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('free_user_limit') border-red-500 @enderror" 
                           id="free_user_limit" 
                           name="free_user_limit" 
                           value="{{ old('free_user_limit', $trendingPrompt->free_user_limit ?? 3) }}" 
                           min="0" 
                           required>
                    @error('free_user_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="paid_amount" class="block text-sm font-medium text-gray-700">Paid Amount</label>
                    <input type="number" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('paid_amount') border-red-500 @enderror" 
                           id="paid_amount" 
                           name="paid_amount" 
                           value="{{ old('paid_amount', $trendingPrompt->paid_amount ?? '') }}" 
                           min="0" 
                           step="0.01">
                    @error('paid_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded @error('is_active') border-red-500 @enderror" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $trendingPrompt->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ isset($trendingPrompt) ? 'Update' : 'Create' }} Prompt
                    </button>
                    <a href="{{ route('admin.trending-prompts.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 