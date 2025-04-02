<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <!-- Search Bar -->
    <div class="relative mb-8">
        <input type="text" placeholder="Search any topic and discover viral posts" class="w-full px-4 py-3 pl-12 bg-white rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Total Posts</h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $totalPosts ?? 0 }}</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Engagement Rate</h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $engagementRate ?? '0%' }}</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Viral Score</h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $viralScore ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('post-generator.index') }}" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create New Post
            </a>
            <a href="{{ route('viral-content.index') }}" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Generate Video
            </a>
            <a href="{{ route('viral-content.index') }}" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                View Analytics
            </a>
            <a href="{{ route('profile.edit') }}" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Update Profile
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
        <div class="space-y-4">
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Welcome to NextViralPost!</p>
                    <p class="text-sm text-gray-500">Start creating viral content for your social media.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 