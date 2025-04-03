@php
use Illuminate\Support\Str;
@endphp

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
                <h3 class="text-lg font-semibold text-gray-900">Posts Generated</h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $totalPosts }}</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Engagement Rate <span class="text-xs font-normal text-gray-500">(Coming Soon)</span></h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $engagementRate }}</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Viral Score <span class="text-xs font-normal text-gray-500">(Coming Soon)</span></h3>
                <span class="text-2xl font-bold text-indigo-600">{{ $viralScore }}</span>
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
            <a href="#" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center relative">
                <div class="absolute top-2 right-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">Coming Soon</div>
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Generate Video
            </a>
            <a href="#" class="p-4 border-2 border-dashed border-gray-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition-colors text-center relative">
                <div class="absolute top-2 right-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">Coming Soon</div>
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

    <!-- Upcoming Features -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 border-2 border-dashed border-gray-200 rounded-lg text-center">
                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full inline-block mb-2">Coming Soon</div>
                <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="font-medium text-gray-900">LinkedIn Scheduler</h3>
                <p class="text-sm text-gray-500 mt-1">Schedule your posts to be published automatically</p>
            </div>
            <div class="p-4 border-2 border-dashed border-gray-200 rounded-lg text-center">
                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full inline-block mb-2">Coming Soon</div>
                <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="font-medium text-gray-900">LinkedIn Auto Job Apply</h3>
                <p class="text-sm text-gray-500 mt-1">Automatically apply to jobs that match your profile</p>
            </div>
            <div class="p-4 border-2 border-dashed border-gray-200 rounded-lg text-center">
                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full inline-block mb-2">Coming Soon</div>
                <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <h3 class="font-medium text-gray-900">LinkedIn Auto Comment</h3>
                <p class="text-sm text-gray-500 mt-1">Engage with posts automatically with smart comments</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
            
            <!-- Recent Posts -->
            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-700 mb-3">Your Recent Posts</h3>
                <div class="space-y-4">
                    @forelse($recentPosts as $post)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ Str::limit($post->content, 50) }}</p>
                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="ml-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
                            No posts yet. Create your first post!
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Recent Interactions -->
            <div>
                <h3 class="text-md font-medium text-gray-700 mb-3">Recent Interactions</h3>
                <div class="space-y-4">
                    @forelse($recentInteractions as $interaction)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    @if($interaction->type == 'bookmark')
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $interaction->type == 'bookmark' ? 'Bookmarked' : 'Used as inspiration' }} a viral template
                                </p>
                                <p class="text-xs text-gray-500">{{ $interaction->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
                            No interactions yet. Start exploring viral templates!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Trending Templates -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Trending Templates</h2>
                <div class="space-y-4">
                    @forelse($trendingTemplates as $template)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-900 mb-2">{{ Str::limit($template->post_content, 60) }}</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span>{{ $template->interactions_count }} interactions</span>
                                </div>
                                <span>{{ $template->date_posted->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
                            No trending templates yet.
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Bookmarked Templates -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Your Bookmarks</h2>
                <div class="space-y-4">
                    @forelse($bookmarkedTemplates as $template)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-900 mb-2">{{ Str::limit($template->post_content, 60) }}</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    <span>Bookmarked</span>
                                </div>
                                <span>{{ $template->date_posted->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-gray-50 rounded-lg text-center text-gray-500">
                            No bookmarked templates yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 