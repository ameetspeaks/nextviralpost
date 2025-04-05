<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%);
        }
        .gradient-border {
            border-image: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%) 1;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
        @auth
            <div class="flex">
                <!-- Mobile menu button -->
                <button type="button" 
                        class="lg:hidden fixed top-4 left-4 z-50 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        @click="sidebarOpen = !sidebarOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Overlay for mobile -->
                <div class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
                     x-show="sidebarOpen"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="sidebarOpen = false">
                </div>

                <!-- Sidebar -->
                <div class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
                     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
                    <div class="h-full bg-white border-r flex flex-col">
                        <!-- Logo -->
                        <div class="p-6">
                            <div class="flex items-center space-x-3">
                                <svg class="w-10 h-10 gradient-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="text-2xl font-bold gradient-text">NextViralPost</span>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <nav class="flex-1 px-4 py-4">
                            <div class="space-y-2">
                                <!-- Dashboard -->
                                <a href="{{ route('dashboard') }}" 
                                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Dashboard
                                </a>

                                <!-- Post Generator -->
                                <a href="{{ route('post-generator.index') }}"
                                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('post-generator.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Generate Post
                                </a>

                                <!-- Viral Recipe -->
                                <a href="{{ route('viral-content.index') }}"
                                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('viral-content.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Viral Recipe
                                </a>

                                <!-- Bookmarks -->
                                <a href="{{ route('bookmarks.index') }}"
                                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('bookmarks.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    Bookmarks
                                </a>

                                <!-- My Posts -->
                                <a href="{{ route('my-posts.index') }}"
                                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('my-posts.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                                    </svg>
                                    My Posts
                                </a>
                            </div>
                        </nav>

                        <!-- User Info -->
                        <div class="p-4 border-t">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-700 font-medium">{{ substr(auth()->user()->name ?? '', 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ auth()->user()->name ?? 'Guest' }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ auth()->user()->email ?? '' }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-400 hover:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1 lg:ml-64">
                    <!-- Page Content -->
                    <main class="p-6 lg:p-8">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        @else
            <!-- Guest Layout -->
            {{ $slot }}
        @endauth
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 