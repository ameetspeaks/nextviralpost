<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f7ff;
        }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-[#f8f7ff]">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                    <h1 class="text-xl font-bold gradient-text">NextViralPost</h1>
                </div>
            </div>
            <nav class="mt-4">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Generate Post -->
                <a href="{{ route('post-generator.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('post-generator.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Generate Post
                </a>

                <!-- Viral Recipe -->
                <a href="{{ route('viral-content.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('viral-content.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Viral Recipe
                </a>

                <!-- Bookmarks -->
                <a href="{{ route('bookmarks.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    Bookmarks
                </a>

                <!-- My Posts -->
                <a href="{{ route('my-posts.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('my-posts.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                    </svg>
                    My Posts
                </a>

                <!-- Profile -->
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="loading-spinner hidden mr-2">
                            <svg class="animate-spin h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span class="button-text">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                {{ $header ?? '' }}

                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Logout Form Handler
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const button = form.querySelector('button');
            const loadingSpinner = form.querySelector('.loading-spinner');
            const buttonText = form.querySelector('.button-text');
            
            // Disable button and show loading state
            button.disabled = true;
            loadingSpinner.classList.remove('hidden');
            buttonText.textContent = 'Signing out...';
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(Object.fromEntries(new FormData(form)))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    // Reset button state
                    button.disabled = false;
                    loadingSpinner.classList.add('hidden');
                    buttonText.textContent = 'Sign Out';
                    
                    // Show error if any
                    alert('Failed to logout. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button state
                button.disabled = false;
                loadingSpinner.classList.add('hidden');
                buttonText.textContent = 'Sign Out';
                
                alert('An error occurred while logging out. Please try again.');
            });
        });
    </script>
</body>
</html> 