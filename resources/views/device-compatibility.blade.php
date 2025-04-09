<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Compatibility - NextViralPost</title>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-xl sm:text-2xl font-bold gradient-text">NextViralPost</a>
                </div>
                <div class="flex flex-col items-center space-y-2 sm:space-y-0 sm:flex-row sm:space-x-4">
                    <a href="{{ route('register') }}" class="text-sm sm:text-base gradient-bg text-white px-3 sm:px-4 py-2 rounded-lg hover:opacity-90 transition-colors">
                        Start For Free
                    </a>
                    <a href="{{ route('login') }}" class="text-sm sm:text-base text-gray-600 hover:text-gray-900">Log in</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4 pt-20">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Please Use a Computer</h1>
            <p class="text-gray-600 mb-6">
                NextViralPost is currently optimized for desktop and laptop computers. Please access the platform from your computer for the best experience.
            </p>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-600">
                    We're working on mobile support. Stay tuned for updates!
                </p>
            </div>

            <a href="/" class="inline-flex items-center px-6 py-3 text-base font-medium text-white gradient-bg rounded-lg hover:opacity-90 transition-colors">
                Return to Homepage
            </a>
        </div>
    </div>
</body>
</html> 