<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - NextViralPost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f7ff;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <!-- Left Side - Image Grid -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#1a1942] p-8">
            <div class="grid grid-cols-2 gap-4 w-full">
                <!-- Testimonial Card -->
                <div class="bg-[#fef6e1] p-4 rounded-xl">
                    <p class="text-[#1a1942] text-sm mb-4">"NextViralPost made social media writing easy, turning my ideas into engaging content."</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="User" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="text-sm font-semibold text-[#1a1942]">John Smith</p>
                            <p class="text-xs text-[#1a1942]/70">Marketing Lead • 15K followers</p>
                        </div>
                    </div>
                </div>
                <!-- Decorative Images -->
                <div class="bg-[#2a2955] rounded-xl"></div>
                <div class="bg-[#2a2955] rounded-xl"></div>
                <!-- Stats Card -->
                <div class="bg-[#2563eb] p-4 rounded-xl flex items-center justify-center">
                    <div class="text-center text-white">
                        <h3 class="text-3xl font-bold mb-1">300x</h3>
                        <p class="text-sm opacity-90">Engagement Increase</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 lg:px-16 xl:px-24">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Let's get started!</h1>
                    <p class="text-lg">
                        <span class="text-indigo-600">Start for FREE</span>
                        <span class="mx-2 text-gray-400">|</span>
                        <span class="text-pink-500">No card needed</span>
                    </p>
                </div>

                <!-- Google Sign Up Button -->
                <button class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 font-medium hover:bg-gray-50 transition-colors mb-6">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Sign up with Google
                </button>

                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-[#f8f7ff] text-gray-500">or use email</span>
                    </div>
                </div>

                <form id="registerForm" class="space-y-4" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Your Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="eg. Jane Smith" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="hello@example.com" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="4+ characters" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600" placeholder="Confirm your password" required>
                    </div>

                    <div id="error-message" class="hidden text-red-500 text-sm text-center"></div>

                    <button type="submit" id="submit-button" class="w-full bg-indigo-600 text-white rounded-lg px-4 py-3 font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-colors">
                        Create Account
                    </button>

                    <p class="text-sm text-center text-gray-600 mt-4">
                        By creating an account, you agree to the
                        <a href="#" class="text-indigo-600 hover:text-indigo-700">Terms of Service</a>
                    </p>

                    <p class="text-sm text-center text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
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
                Creating your account...
            `;
            
            // Hide any previous error messages
            errorMessage.classList.add('hidden');
            
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    }
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'An error occurred');
                        });
                    } else {
                        throw new Error('Server error. Please try again.');
                    }
                }
                return response.json();
            })
            .then(data => {
                if (data.errors) {
                    // Show validation errors
                    errorMessage.textContent = Object.values(data.errors).flat().join(', ');
                    errorMessage.classList.remove('hidden');
                } else if (data.message) {
                    // Show success message and redirect
                    window.location.href = data.redirect || '/dashboard';
                } else {
                    // Show generic error
                    errorMessage.textContent = 'An error occurred during registration. Please try again.';
                    errorMessage.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = error.message || 'An error occurred during registration. Please try again.';
                errorMessage.classList.remove('hidden');
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                submitButton.disabled = false;
                submitButton.innerHTML = 'Create Account';
            });
        });
    </script>
</body>
</html> 