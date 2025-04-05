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
                        <h1 class="text-2xl font-semibold text-gray-900">Trending Topics</h1>
                        <p class="mt-1 text-sm text-gray-500">Discover what's trending in your industry</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($trendingTopics as $topic)
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $topic->name }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $topic->trend_direction === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $topic->trend_direction === 'up' ? '↑' : '↓' }} {{ $topic->change_percentage }}%
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-4">{{ $topic->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                            {{ $topic->trend_score }}% trending
                                        </div>
                                        <a href="{{ route('trending-topics.show', $topic) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $trendingTopics->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 