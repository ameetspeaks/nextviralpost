<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Post Generator</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Post Generation Form -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-4">Generate Your Post</h2>
                            <form id="postGeneratorForm" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="post_type_id" class="block text-sm font-medium text-gray-700">Post Type</label>
                                    <select id="post_type_id" name="post_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select a post type</option>
                                        @foreach($postTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="tone_id" class="block text-sm font-medium text-gray-700">Tone</label>
                                    <select id="tone_id" name="tone_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                        <option value="">Select a tone</option>
                                        @foreach($tones as $tone)
                                            <option value="{{ $tone->id }}">{{ $tone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                                    <input type="text" id="keywords" name="keywords" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter keywords (comma separated)" required>
                                </div>

                                <div>
                                    <label for="word_limit" class="block text-sm font-medium text-gray-700">Word Limit</label>
                                    <input type="number" id="word_limit" name="word_limit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="50" min="50" max="300" required>
                                    <p class="mt-1 text-sm text-gray-500">Minimum: 50 words, Maximum: 300 words</p>
                                </div>

                                <div>
                                    <label for="raw_content" class="block text-sm font-medium text-gray-700">Post Content</label>
                                    <textarea id="raw_content" name="raw_content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter your post content or key points to include" required></textarea>
                                </div>

                                <div>
                                    <button type="submit" id="generateButton" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Generate Post
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column: Generated Post Display -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold mb-4">Generated Post</h2>
                            <div id="generatedPostContainer" class="hidden">
                                <!-- LinkedIn-style Post Card -->
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4">
                                    <!-- Post Header -->
                                    <div class="p-4 flex items-start justify-between border-b border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <!-- Avatar -->
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                                <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
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

                                    <!-- Post Footer -->
                                    <div class="px-4 py-3 border-t border-gray-100">
                                        <div class="flex flex-col space-y-3">
                                            <!-- Action Buttons -->
                                            <div class="flex justify-between items-center">
                                                <div class="flex space-x-4">
                                                    <button id="copyButton" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900">
                                                        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                                        </svg>
                                                        Copy
                                                    </button>
                                                    <button id="postToLinkedIn" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700">
                                                        <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"></path>
                                                        </svg>
                                                        Post on LinkedIn
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Feedback Section -->
                                            <div class="flex items-center justify-center space-x-6 pt-2 border-t border-gray-100">
                                                <span class="text-sm text-gray-500">Was this template helpful?</span>
                                                <div class="flex space-x-4">
                                                    <button id="positiveFeedback" class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors">
                                                        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                                        </svg>
                                                        Helpful
                                                    </button>
                                                    <button id="negativeFeedback" class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                                                        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2"></path>
                                                        </svg>
                                                        Not Helpful
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Regenerate Section -->
                                            <div id="regenerateSection" class="hidden flex items-center justify-center space-x-6 pt-2 border-t border-gray-100">
                                                <button id="regenerateButton" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Regenerate Post
                                                </button>
                                            </div>
                                            <div id="maxRegenerationsMessage" class="hidden text-center text-sm text-red-600 pt-2">
                                                Maximum regeneration attempts reached. Please try again later.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="loadingIndicator" class="hidden">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                                    <span class="text-gray-600">Generating your post...</span>
                                </div>
                            </div>
                            <div id="errorMessage" class="hidden">
                                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700" id="errorText"></p>
                                        </div>
                                    </div>
                                </div>
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
            const form = document.getElementById('postGeneratorForm');
            const generateButton = document.getElementById('generateButton');
            const generatedPostContainer = document.getElementById('generatedPostContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            const generatedContent = document.getElementById('generatedContent');
            const copyButton = document.getElementById('copyButton');
            const bookmarkButton = document.getElementById('bookmarkButton');
            const postToLinkedIn = document.getElementById('postToLinkedIn');
            const regenerateSection = document.getElementById('regenerateSection');
            const regenerateButton = document.getElementById('regenerateButton');
            const maxRegenerationsMessage = document.getElementById('maxRegenerationsMessage');
            let currentPostId = null;
            let canRegenerate = true;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Reset UI
                generatedPostContainer.classList.add('hidden');
                errorMessage.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
                regenerateSection.classList.add('hidden');
                maxRegenerationsMessage.classList.add('hidden');

                try {
                    const formData = {
                        post_type_id: document.getElementById('post_type_id').value,
                        tone_id: document.getElementById('tone_id').value,
                        keywords: document.getElementById('keywords').value,
                        raw_content: document.getElementById('raw_content').value,
                        word_limit: document.getElementById('word_limit').value
                    };

                    const response = await fetch('{{ route("post-generator.generate") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to generate post');
                    }

                    // Show generated content
                    generatedContent.innerHTML = data.generated_content.replace(/\n/g, '<br>');
                    currentPostId = data.post_id;
                    generatedPostContainer.classList.remove('hidden');
                    loadingIndicator.classList.add('hidden');
                    generateButton.disabled = true;

                } catch (error) {
                    errorText.textContent = error.message;
                    errorMessage.classList.remove('hidden');
                    loadingIndicator.classList.add('hidden');
                    generateButton.disabled = false;
                }
            });

            copyButton.addEventListener('click', function() {
                const text = generatedContent.innerText + "\n\n🔗 Post generated by NextPostAI - https://nextpostai.pandeyamit.com";
                navigator.clipboard.writeText(text).then(() => {
                    const originalHTML = copyButton.innerHTML;
                    copyButton.innerHTML = `
                        <svg class="w-5 h-5 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-green-600">Copied!</span>
                    `;
                    setTimeout(() => {
                        copyButton.innerHTML = originalHTML;
                    }, 2000);
                });
            });

            postToLinkedIn.addEventListener('click', function() {
                const text = generatedContent.innerText;
                const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=https://nextpostai.pandeyamit.com&summary=${encodeURIComponent(text)}`;
                window.open(linkedInUrl, '_blank', 'width=600,height=600');
            });

            // Add regenerate button handler
            regenerateButton.addEventListener('click', async function() {
                if (!currentPostId || !canRegenerate) return;

                loadingIndicator.classList.remove('hidden');
                regenerateButton.disabled = true;

                try {
                    const response = await fetch(`/post-generator/${currentPostId}/regenerate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to regenerate post');
                    }

                    generatedContent.innerHTML = data.generated_content.replace(/\n/g, '<br>');
                    canRegenerate = data.can_regenerate;

                    if (!canRegenerate) {
                        regenerateSection.classList.add('hidden');
                        maxRegenerationsMessage.classList.remove('hidden');
                    }

                    loadingIndicator.classList.add('hidden');
                    regenerateButton.disabled = false;

                } catch (error) {
                    errorText.textContent = error.message;
                    errorMessage.classList.remove('hidden');
                    loadingIndicator.classList.add('hidden');
                    regenerateButton.disabled = false;
                }
            });

            // Update feedback handlers
            document.getElementById('positiveFeedback').addEventListener('click', async function() {
                if (!currentPostId) return;

                try {
                    const response = await fetch(`/post-generator/${currentPostId}/feedback`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({ feedback: 'positive' })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.classList.add('text-green-600');
                        document.getElementById('negativeFeedback').classList.remove('text-red-600');
                        regenerateSection.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Failed to submit feedback:', error);
                }
            });

            document.getElementById('negativeFeedback').addEventListener('click', async function() {
                if (!currentPostId) return;

                try {
                    const response = await fetch(`/post-generator/${currentPostId}/feedback`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({ feedback: 'negative' })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.classList.add('text-red-600');
                        document.getElementById('positiveFeedback').classList.remove('text-green-600');
                        regenerateSection.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Failed to submit feedback:', error);
                }
            });

            // Update bookmark button to use SVG fill for active state
            bookmarkButton.addEventListener('click', async function() {
                if (!currentPostId) return;

                try {
                    const response = await fetch(`/post-generator/${currentPostId}/bookmark`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        const svg = this.querySelector('svg');
                        if (data.is_bookmarked) {
                            svg.setAttribute('fill', 'currentColor');
                            svg.classList.add('text-yellow-500');
                        } else {
                            svg.setAttribute('fill', 'none');
                            svg.classList.remove('text-yellow-500');
                        }
                    }
                } catch (error) {
                    console.error('Failed to update bookmark status:', error);
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 