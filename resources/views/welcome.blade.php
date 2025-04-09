<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextViralPost - AI-Powered LinkedIn Growth Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #0077B5 0%, #E1306C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #0077B5 0%, #E1306C 100%);
        }
        .gradient-border {
            position: relative;
        }
        .gradient-border::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 0.5rem;
            padding: 2px;
            background: linear-gradient(135deg, #0077B5 0%, #E1306C 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold gradient-text">NextViralPost</a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col items-center space-y-2 sm:space-y-0 sm:flex-row sm:space-x-4">
                        <a href="{{ route('register') }}" class="text-sm sm:text-base gradient-bg text-white px-3 sm:px-4 py-2 rounded-lg hover:opacity-90 transition-colors">
                            Start For Free
                        </a>
                        <a href="{{ route('login') }}" class="text-sm sm:text-base text-gray-600 hover:text-gray-900">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-blue-50 border border-blue-100">
                    <p class="text-sm font-medium text-blue-600">The Ultimate LinkedIn Growth Platform</p>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 mb-8">
                    Transform Your
                    <span class="gradient-text">LinkedIn Profile</span>
                    <br class="hidden sm:block" />
                    Into a Growth Engine
                </h1>
                <p class="max-w-2xl mx-auto text-xl text-gray-600 mb-12">
                    NextViralPost helps professionals optimize their LinkedIn presence with AI-powered content creation, profile optimization, and automated engagement tools.
                </p>
                
                <!-- Feature Pills -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <div class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full shadow-sm">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-700">Profile Optimization Score</span>
                    </div>
                    <div class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full shadow-sm">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-gray-700">AI Content Generation</span>
                    </div>
                    <div class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full shadow-sm">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-700">Smart Post Scheduling</span>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium text-white gradient-bg rounded-lg hover:opacity-90 transition-colors">
                    Start Your Free Trial
                </a>
                <p class="mt-4 text-sm text-gray-500">14-day free trial • No credit card required</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Everything You Need to Grow on LinkedIn</h2>
                <p class="mt-4 text-xl text-gray-600">Powerful tools designed specifically for LinkedIn professionals</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Profile Optimization</h3>
                    <p class="text-gray-600">Get a detailed analysis of your LinkedIn profile with actionable recommendations for improvement.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">AI Content Creation</h3>
                    <p class="text-gray-600">Generate engaging LinkedIn posts tailored to your industry and audience using advanced AI.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Scheduling</h3>
                    <p class="text-gray-600">Schedule posts at optimal times based on your audience's activity patterns.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Engagement Automation</h3>
                    <p class="text-gray-600">Automatically engage with your network while maintaining a personal touch.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Performance Analytics</h3>
                    <p class="text-gray-600">Track your growth with detailed analytics and actionable insights.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-xl shadow-sm gradient-border feature-card">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Job Application Assistant</h3>
                    <p class="text-gray-600">Streamline your job search with AI-powered application tracking and optimization.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">How NextViralPost Works</h2>
                <p class="mt-4 text-xl text-gray-600">Three simple steps to transform your LinkedIn presence</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Optimize Your Profile</h3>
                    <p class="text-gray-600">Get a detailed analysis of your LinkedIn profile with specific recommendations for improvement.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Create Engaging Content</h3>
                    <p class="text-gray-600">Use our AI to generate high-quality posts that resonate with your professional audience.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Grow Your Network</h3>
                    <p class="text-gray-600">Automate engagement and track your growth with detailed analytics and insights.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-600 to-pink-600 rounded-2xl p-8 md:p-12 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Ready to Transform Your LinkedIn Presence?</h2>
                <p class="text-xl mb-8 opacity-90">Join thousands of professionals who are growing their network with NextViralPost</p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 text-lg font-medium bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors">
                    Start Your Free Trial
                </a>
                <p class="mt-4 text-sm opacity-80">14-day free trial • No credit card required</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="text-2xl font-bold gradient-text">NextViralPost</a>
                    <p class="mt-2 text-gray-600">The Ultimate LinkedIn Growth Platform</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-gray-500">&copy; 2024 NextViralPost. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
