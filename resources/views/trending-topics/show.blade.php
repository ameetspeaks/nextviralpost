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
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $trendingTopic->name }}</h1>
                        <p class="mt-1 text-sm text-gray-500">Trending topic details and insights</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $trendingTopic->trend_direction === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $trendingTopic->trend_direction === 'up' ? '↑' : '↓' }} {{ $trendingTopic->change_percentage }}%
                        </span>
                        <a href="{{ route('trending-topics.index') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Topics
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Topic Details -->
                        <div class="lg:col-span-2">
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Topic Overview</h2>
                                    <p class="text-sm text-gray-500 mb-6">{{ $trendingTopic->description }}</p>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="p-4 bg-gray-50 rounded-lg">
                                            <h3 class="text-sm font-medium text-gray-900">Trend Score</h3>
                                            <p class="mt-1 text-2xl font-semibold text-indigo-600">{{ $trendingTopic->trend_score }}%</p>
                                        </div>
                                        <div class="p-4 bg-gray-50 rounded-lg">
                                            <h3 class="text-sm font-medium text-gray-900">Change</h3>
                                            <p class="mt-1 text-2xl font-semibold {{ $trendingTopic->trend_direction === 'up' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $trendingTopic->trend_direction === 'up' ? '+' : '-' }}{{ $trendingTopic->change_percentage }}%
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Related Content -->
                        <div>
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Related Content</h2>
                                    <div class="space-y-4">
                                        @foreach($trendingTopic->related_content as $content)
                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                <h3 class="text-sm font-medium text-gray-900">{{ $content->title }}</h3>
                                                <p class="mt-1 text-xs text-gray-500">{{ $content->source }}</p>
                                                <a href="{{ $content->url }}" target="_blank" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                                    Read More
                                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 