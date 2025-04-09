@extends('layouts.superadmin')

@section('title', 'View Trending Prompt')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Trending Prompt Details</h2>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Title</h3>
                <p class="text-gray-900">{{ $trendingPrompt->title }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Description</h3>
                <p class="text-gray-900">{{ $trendingPrompt->description }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Prompt Template</h3>
                <p class="text-gray-900">{{ $trendingPrompt->prompt_template }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Requirements</h3>
                <p class="text-gray-900">
                    @if(is_array($trendingPrompt->requirements))
                        {{ implode(', ', $trendingPrompt->requirements) }}
                    @else
                        {{ $trendingPrompt->requirements }}
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">LLM Model</h3>
                <p class="text-gray-900">{{ $trendingPrompt->llm_model }}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Status</h3>
                <p class="text-gray-900">{{ $trendingPrompt->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.trending-prompts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 