<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Post Generator
                    </h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Post Generation Form -->
                        <div class="bg-gradient-to-br from-white to-indigo-50 p-6 rounded-lg shadow-md border border-indigo-100">
                            <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-800">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Generate Your Post
                            </h2>
                            <form id="postGeneratorForm" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="post_type_id" class="block text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Post Type
                                    </label>
                                    <select id="post_type_id" name="post_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select a post type</option>
                                        @foreach($postTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="tone_id" class="block text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tone
                                    </label>
                                    <select id="tone_id" name="tone_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select a tone</option>
                                        @foreach($tones as $tone)
                                            <option value="{{ $tone->id }}">{{ $tone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="keywords" class="block text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Keywords
                                    </label>
                                    <input type="text" id="keywords" name="keywords" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter keywords (comma separated)" required>
                                </div>

                                <div>
                                    <label for="word_limit" class="block text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Word Limit
                                    </label>
                                    <input type="number" id="word_limit" name="word_limit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="50" min="50" max="300" required>
                                    <p class="mt-1 text-sm text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Minimum: 50 words, Maximum: 300 words
                                    </p>
                                </div>

                                <div>
                                    <label for="raw_content" class="block text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Post Content
                                    </label>
                                    <textarea id="raw_content" name="raw_content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter your post content or key points to include" required></textarea>
                                </div>

                                <div>
                                    <button type="submit" id="generateButton" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Generate Post
                                    </button>
                                </div>
                                
                                <!-- New Post Button (Hidden by default) -->
                                <div id="newPostButtonContainer" class="hidden">
                                    <button type="button" id="newPostButton" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Create New Post
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column: Generated Post Display -->
                        <div class="bg-gradient-to-br from-white to-indigo-50 p-6 rounded-lg shadow-md border border-indigo-100">
                            <h2 class="text-xl font-semibold mb-4 flex items-center text-indigo-800">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Generated Post
                            </h2>
                            <div id="generatedPostContainer" class="hidden">
                                <!-- LinkedIn-style Post Card -->
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4">
                                    <!-- Post Header -->
                                    <div class="p-4 flex items-start justify-between border-b border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <!-- Avatar -->
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="h-6 w-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                                </svg>
                                            </div>
                                            <!-- User Info -->
                                            <div class="flex flex-col">
                                                <h3 class="font-semibold text-[15px] text-gray-900 leading-tight">{{ auth()->user()->name }}</h3>
                                                <div class="flex items-center text-xs text-gray-500 mt-0.5">
                                                    <span>{{ auth()->user()->role->name ?? 'Professional' }} • {{ auth()->user()->industry->name ?? 'Technology' }}</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-500 mt-0.5">
                                                    <span>Just now</span>
                                                    <span class="mx-1">•</span>
                                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0ZM3.5 8a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 0-1H4a.5.5 0 0 0-.5.5Zm6.5.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Bookmark Button in Header -->
                                        <button id="bookmarkButton" class="p-1 hover:bg-gray-100 rounded-full">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Post Content -->
                                    <div class="p-4">
                                        <div id="generatedContent" class="prose max-w-none text-gray-800 whitespace-pre-line"></div>
                                    </div>
                                    
                                    <!-- Post Actions -->
                                    <div class="p-4 border-t border-gray-100 flex items-center justify-between">
                                        <div class="flex space-x-4">
                                            <button id="copyButton" class="flex items-center text-gray-500 hover:text-indigo-600 transition-colors">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                                </svg>
                                                <span class="text-sm">Copy</span>
                                            </button>
                                            <button id="postToLinkedIn" class="flex items-center text-gray-500 hover:text-indigo-600 transition-colors">
                                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"></path>
                                                </svg>
                                                <span class="text-sm">Share on LinkedIn</span>
                                            </button>
                                        </div>
                                        <button id="regenerateButton" class="flex items-center text-indigo-600 hover:text-indigo-800 transition-colors">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Regenerate</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Feedback Section -->
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Was this post helpful?</h3>
                                    <div class="flex space-x-4">
                                        <button id="positiveFeedback" class="flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                            </svg>
                                            <span>Yes</span>
                                        </button>
                                        <button id="negativeFeedback" class="flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2.5"></path>
                                            </svg>
                                            <span>No</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Regeneration Limit Message -->
                                <div id="maxRegenerationsMessage" class="hidden mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200 text-yellow-800">
                                    <p class="text-sm">Maximum regeneration attempts reached. Please try again later.</p>
                                </div>
                                
                                <!-- Regeneration Tip -->
                                <div id="regenerationTip" class="hidden mt-4 p-4 bg-indigo-50 rounded-lg border border-indigo-200 text-indigo-800">
                                    <p class="text-sm">Not happy with the result? Give negative feedback to regenerate.</p>
                                </div>
                            </div>
                            
                            <!-- Empty State with Animation -->
                            <div id="emptyState" class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="animate-pulse mb-4">
                                    <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">No Post Generated Yet</h3>
                                <p class="text-gray-500 max-w-md">Fill out the form on the left and click "Generate Post" to create your content.</p>
                            </div>
                            
                            <!-- Loading State -->
                            <div id="loadingState" class="hidden flex flex-col items-center justify-center py-12 text-center">
                                <div class="animate-spin mb-4">
                                    <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Generating Your Post</h3>
                                <p class="text-gray-500 max-w-md">Please wait while we create the perfect content for you...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const postGeneratorForm = document.getElementById('postGeneratorForm');
        const generatedPostContainer = document.getElementById('generatedPostContainer');
        const emptyState = document.getElementById('emptyState');
        const loadingState = document.getElementById('loadingState');
        const generatedContent = document.getElementById('generatedContent');
        const generateButton = document.getElementById('generateButton');
        const newPostButtonContainer = document.getElementById('newPostButtonContainer');
        const newPostButton = document.getElementById('newPostButton');
        const regenerateButton = document.getElementById('regenerateButton');
        const bookmarkButton = document.getElementById('bookmarkButton');
        const positiveFeedback = document.getElementById('positiveFeedback');
        const negativeFeedback = document.getElementById('negativeFeedback');
        const copyButton = document.getElementById('copyButton');
        const postToLinkedIn = document.getElementById('postToLinkedIn');
        const maxRegenerationsMessage = document.getElementById('maxRegenerationsMessage');
        const regenerationTip = document.getElementById('regenerationTip');
        
        let currentPostId = null;
        let regenerationCount = 0;
        let canRegenerate = false; // Start with regenerate disabled
        
        // Handle new post button click
        newPostButton.addEventListener('click', function() {
            // Simply reload the page
            window.location.reload();
        });
        
        // Handle form submission
        postGeneratorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            emptyState.classList.add('hidden');
            generatedPostContainer.classList.add('hidden');
            loadingState.classList.remove('hidden');
            maxRegenerationsMessage.classList.add('hidden');
            regenerationTip.classList.add('hidden');
            
            // Disable generate button
            generateButton.disabled = true;
            generateButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            `;
            
            // Get form data
            const formData = new FormData(postGeneratorForm);
            
            // Send request to generate post
            fetch('/post-generator/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading state
                loadingState.classList.add('hidden');
                
                if (data.error) {
                    // Show error message
                    alert(data.error);
                    
                    // Reset generate button
                    generateButton.disabled = false;
                    generateButton.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Post
                    `;
                    return;
                }
                
                // Store post ID
                currentPostId = data.post_id;
                
                // Update generated content
                generatedContent.textContent = data.generated_content;
                
                // Show generated post
                generatedPostContainer.classList.remove('hidden');
                
                // Hide generate button and show new post button
                generateButton.classList.add('hidden');
                newPostButtonContainer.classList.remove('hidden');
                
                // Reset regeneration count
                regenerationCount = 0;
                canRegenerate = false; // Regenerate is disabled until negative feedback
                regenerateButton.disabled = true;
                regenerateButton.classList.add('opacity-50', 'cursor-not-allowed');
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hide loading state
                loadingState.classList.add('hidden');
                
                // Show error message
                alert('An error occurred while generating the post. Please try again.');
                
                // Reset generate button
                generateButton.disabled = false;
                generateButton.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Generate Post
                `;
            });
        });
        
        // Handle copy button click
        copyButton.addEventListener('click', function() {
            const text = generatedContent.innerText + "\n\n🔗 Post generated by NextPostAI - https://nextpostai.pandeyamit.com";
            navigator.clipboard.writeText(text).then(() => {
                const originalHTML = copyButton.innerHTML;
                copyButton.innerHTML = `
                    <svg class="w-5 h-5 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-green-600">Copied!</span>
                `;
                setTimeout(() => {
                    copyButton.innerHTML = originalHTML;
                }, 2000);
            });
        });
        
        // Handle LinkedIn share button click
        postToLinkedIn.addEventListener('click', function() {
            const text = generatedContent.innerText;
            const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=https://nextpostai.pandeyamit.com&summary=${encodeURIComponent(text)}`;
            window.open(linkedInUrl, '_blank', 'width=600,height=600');
        });
        
        // Handle regenerate button click
        regenerateButton.addEventListener('click', function() {
            if (!currentPostId || !canRegenerate) return;
            
            // Show loading state
            generatedPostContainer.classList.add('hidden');
            loadingState.classList.remove('hidden');
            
            // Send request to regenerate post
            fetch(`/post-generator/regenerate/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading state
                loadingState.classList.add('hidden');
                
                if (data.error) {
                    // Show error message
                    alert(data.error);
                    return;
                }
                
                // Update generated content
                generatedContent.textContent = data.generated_content;
                
                // Show generated post
                generatedPostContainer.classList.remove('hidden');
                
                // Increment regeneration count
                regenerationCount++;
                
                // Check if max regenerations reached
                if (regenerationCount >= 2) {
                    canRegenerate = false;
                    regenerateButton.disabled = true;
                    regenerateButton.classList.add('opacity-50', 'cursor-not-allowed');
                    maxRegenerationsMessage.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hide loading state
                loadingState.classList.add('hidden');
                
                // Show error message
                alert('An error occurred while regenerating the post. Please try again.');
            });
        });
        
        // Handle bookmark button click
        bookmarkButton.addEventListener('click', function() {
            if (!currentPostId) return;
            
            // Toggle bookmark icon
            const icon = bookmarkButton.querySelector('svg');
            icon.classList.toggle('text-indigo-600');
            icon.classList.toggle('fill-current');
            
            // Send request to toggle bookmark
            fetch(`/post-generator/bookmark/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update bookmark icon based on response
                    if (data.is_bookmarked) {
                        icon.classList.add('text-indigo-600', 'fill-current');
                    } else {
                        icon.classList.remove('text-indigo-600', 'fill-current');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        // Handle feedback buttons
        positiveFeedback.addEventListener('click', function() {
            sendFeedback('positive');
        });
        
        negativeFeedback.addEventListener('click', function() {
            sendFeedback('negative');
        });
        
        function sendFeedback(type) {
            if (!currentPostId) return;
            
            // Send request to save feedback
            fetch(`/post-generator/feedback/${currentPostId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ feedback: type })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (type === 'positive') {
                        // Show thank you message and hint to refresh for new post
                        alert('Thank you for your feedback! To create a new post, click the "Create New Post" button.');
                    } else if (type === 'negative' && data.can_regenerate) {
                        // Enable regeneration for negative feedback
                        canRegenerate = true;
                        regenerateButton.disabled = false;
                        regenerateButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        maxRegenerationsMessage.classList.add('hidden');
                        regenerationTip.classList.remove('hidden');
                        
                        // Show message about regeneration
                        alert('Thank you for your feedback. You can now regenerate the post.');
                    } else {
                        // Just thank the user
                        alert('Thank you for your feedback!');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
    </script>
    @endpush
</x-app-layout> 