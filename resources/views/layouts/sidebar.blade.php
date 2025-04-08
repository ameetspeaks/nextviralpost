@php
use Illuminate\Support\Facades\Auth;
@endphp

<aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-sm overflow-y-auto">
    <!-- Logo Section -->
    <div class="px-6 py-5 border-b">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span class="ml-3 text-xl font-semibold text-gray-900">NextViralPost</span>
        </div>
        <p class="mt-1 text-sm text-gray-500">AI Post Generator</p>
    </div>

    <!-- Main Navigation -->
    <nav class="px-4 py-6">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <!-- Post Generator -->
            <a href="{{ route('post-generator.index') }}"
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('post-generator.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('post-generator.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Generate Post
            </a>

            <!-- Viral Recipe -->
            <a href="{{ route('viral-content.index') }}"
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('viral-content.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('viral-content.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Viral Recipe
            </a>

            <!-- Bookmarks -->
            <a href="{{ route('bookmarks.index') }}"
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('bookmarks.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                Bookmarks
            </a>

            <!-- My Posts -->
            <a href="{{ route('my-posts.index') }}"
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('my-posts.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('my-posts.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                </svg>
                My Posts
            </a>
        </div>

        <!-- Settings Section -->
        <div class="mt-6 pt-6 border-t">
            <div class="px-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.show') }}"
                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile Settings
                </a>
            </div>
        </div>
    </nav>

    <!-- User Profile Section -->
    <div class="absolute bottom-0 left-0 right-0 border-t bg-white">
        <div class="px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->hasActiveSubscription())
                        <div class="mt-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2 {{ (auth()->user()->activeSubscription->subscription->name === 'Agency Plan') ? 'text-purple-600' : ((auth()->user()->activeSubscription->subscription->name === 'Creator Plan') ? 'text-blue-600' : 'text-green-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ auth()->user()->activeSubscription->subscription->name }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold {{ (auth()->user()->activeSubscription->remaining_credits > 10) ? 'text-green-600' : ((auth()->user()->activeSubscription->remaining_credits > 5) ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ auth()->user()->activeSubscription->remaining_credits }}
                                    </span>
                                    <span class="text-xs text-gray-500">credits</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('subscription.select') }}" class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                            Subscribe Now
                        </a>
                    @endif
                </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-2" id="logout-form">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="p-1.5 text-gray-400 hover:text-gray-500 rounded-lg hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
        </div>
    </div>
</aside>

@push('scripts')
<script>
function confirmLogout() {
    if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endpush 