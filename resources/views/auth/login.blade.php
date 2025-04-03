<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - NextViralPost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f7ff;
        }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <!-- Left Side - Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#1a1942] p-8 items-center justify-center">
            <div class="max-w-xl text-center">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Create viral
                    <span class="text-[#a78bfa]">social media</span>
                    content in minutes
                </h2>
                <p class="text-lg text-gray-300 mb-8">
                    Transform your ideas into engaging posts that go viral. Use AI-powered tools to create content that resonates with your audience.
                </p>
                <div class="flex justify-center space-x-4 mb-12">
                    <div class="bg-[#2a2955] rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-white mb-1">200+</div>
                        <div class="text-sm text-gray-400">Templates</div>
                    </div>
                    <div class="bg-[#2a2955] rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-white mb-1">300x</div>
                        <div class="text-sm text-gray-400">Engagement</div>
                    </div>
                    <div class="bg-[#2a2955] rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-white mb-1">AI</div>
                        <div class="text-sm text-gray-400">Powered</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 lg:px-16 xl:px-24">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back!</h1>
                    <p class="text-lg text-gray-600">Log in to your account to continue</p>
                </div>

                <!-- Google Sign In Button -->
                <button class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 transition-colors mb-6">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Sign in with Google
                </button>

                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-[#f8f7ff] text-gray-500">or use email</span>
                    </div>
                </div>

                <form id="loginForm" class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="hello@example.com" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Enter your password" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Forgot password?</a>
                    </div>

                    <div id="error-message" class="hidden text-red-500 text-sm text-center"></div>

                    <button type="submit" id="submit-button" class="w-full bg-indigo-600 text-white rounded-lg px-4 py-3 font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors">
                        Sign in
                    </button>

                    <p class="text-sm text-center text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Create one for free</a>
                    </p>
                </form>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('submit-button');
            const errorMessage = document.getElementById('error-message');
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Signing in...
            `;

            // Get form data
            const formData = new FormData(this);

            // Submit data
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    errorMessage.textContent = Object.values(data.errors).flat().join(', ');
                    errorMessage.classList.remove('hidden');
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.message) {
                    errorMessage.textContent = data.message;
                    errorMessage.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Sign in';
            });
        });
    </script>
</body>
</html> 