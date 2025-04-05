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
                        <h1 class="text-2xl font-semibold text-gray-900">Repurposed Content</h1>
                        <p class="mt-1 text-sm text-gray-500">View your repurposed content details.</p>
                    </div>
                    <div>
                        <a href="{{ route('repurposed-content.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Content Details -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Original Template</h2>
                        <div class="mt-4 grid grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Title</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $repurposedContent->viralTemplate->title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Category</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $repurposedContent->viralTemplate->category }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Platform</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $repurposedContent->viralTemplate->platform }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tone Used</h3>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $repurposedContent->tone->name }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Your Raw Thoughts</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $repurposedContent->raw_thoughts }}</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Repurposed Content</h2>
                            <button onclick="copyToClipboard()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                Copy Content
                            </button>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap" id="repurposed-content">{{ $repurposedContent->repurposed_content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
function copyToClipboard() {
    const content = document.getElementById('repurposed-content').innerText;
    navigator.clipboard.writeText(content).then(() => {
        // You could add a toast notification here
        alert('Content copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}
</script>
@endpush
@endsection 