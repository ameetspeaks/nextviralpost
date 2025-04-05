@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Main Content Area -->
    <main class="flex-1 ml-56">
        <div class="py-6">
            <div class="max-w-[1600px] mx-auto px-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Repurpose Template</h1>
                        <p class="mt-1 text-sm text-gray-500">Create your own version of this viral template.</p>
                    </div>
                </div>

                <!-- Template Details -->
                <div class="bg-white rounded-lg shadow mb-6 p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Template Details</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Title</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $viralTemplate->title }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Category</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $viralTemplate->category }}</p>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-sm font-medium text-gray-500">Description</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $viralTemplate->description }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Platform</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $viralTemplate->platform }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Success Rate</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ number_format($viralTemplate->success_rate * 100, 1) }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Repurpose Form -->
                <div class="bg-white rounded-lg shadow">
                    <form action="{{ route('repurposed-content.store', $viralTemplate) }}" method="POST" class="p-6">
                        @csrf

                        <!-- Tone Selection -->
                        <div class="mb-6">
                            <label for="tone_id" class="block text-sm font-medium text-gray-700">Select Tone</label>
                            <select id="tone_id" name="tone_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('tone_id') border-red-500 @enderror">
                                <option value="">Choose a tone</option>
                                @foreach($tones as $tone)
                                    <option value="{{ $tone->id }}" {{ old('tone_id') == $tone->id ? 'selected' : '' }}>
                                        {{ $tone->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tone_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raw Thoughts -->
                        <div class="mb-6">
                            <label for="raw_thoughts" class="block text-sm font-medium text-gray-700">Your Raw Thoughts</label>
                            <div class="mt-1">
                                <textarea id="raw_thoughts" name="raw_thoughts" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('raw_thoughts') border-red-500 @enderror" placeholder="Enter your thoughts and ideas here...">{{ old('raw_thoughts') }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Share your thoughts and ideas that you want to incorporate into this template.</p>
                            @error('raw_thoughts')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Repurpose Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 