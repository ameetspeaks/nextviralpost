<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Viral Content</h1>
                <p class="mt-1 text-sm text-gray-500">Discover and get inspired by viral LinkedIn posts</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option>Most Recent</option>
                        <option>Most Popular</option>
                        <option>Most Bookmarked</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Templates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($templates as $template)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-700 font-medium">{{ substr($template->username, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $template->username }}</p>
                                    <p class="text-xs text-gray-500">{{ $template->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-800 line-clamp-3">{{ $template->post_content }}</p>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ number_format($template->likes) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    {{ number_format($template->comments) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    {{ number_format($template->shares) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between border-t pt-4">
                            <button type="button" 
                                    onclick="openInspirationModal('{{ $template->id }}')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Get Inspiration
                            </button>

                            <button type="button"
                                    onclick="toggleBookmark('{{ $template->id }}')"
                                    class="bookmark-btn inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    data-template-id="{{ $template->id }}"
                                    data-bookmarked="{{ $template->isBookmarkedBy(auth()->user()) ? 'true' : 'false' }}">
                                <svg class="h-5 w-5 {{ $template->isBookmarkedBy(auth()->user()) ? 'text-indigo-600' : 'text-gray-400' }}"
                                     fill="{{ $template->isBookmarkedBy(auth()->user()) ? 'currentColor' : 'none' }}"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No viral templates</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first viral template.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $templates->links() }}
        </div>
    </div>

    <!-- Inspiration Modal -->
    <div id="inspirationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" onclick="closeInspirationModal()" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Recreate Post with AI
                        </h3>
                        <div class="mt-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">I want my post to be</label>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button type="button" class="tone-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-tone="insightful">Insightful</button>
                                    <button type="button" class="tone-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-tone="personal">A personal story</button>
                                    <button type="button" class="tone-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-tone="funny">Funny</button>
                                    <button type="button" class="tone-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-tone="controversial">Controversial</button>
                                    <button type="button" class="tone-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-tone="motivational">Motivational</button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="additional_context" class="block text-sm font-medium text-gray-700">Also include (Optional)</label>
                                <div class="mt-1">
                                    <textarea id="additional_context" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="I want this post to be about..."></textarea>
                                </div>
                            </div>

                            <input type="hidden" id="templateId" value="">
                            <input type="hidden" id="selectedTone" value="">

                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="button" onclick="generateWithAI()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Generate with AI
                                </button>
                                <button type="button" onclick="closeInspirationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openInspirationModal(templateId) {
            document.getElementById('templateId').value = templateId;
            document.getElementById('inspirationModal').classList.remove('hidden');
        }

        function closeInspirationModal() {
            document.getElementById('inspirationModal').classList.add('hidden');
            document.getElementById('templateId').value = '';
            document.getElementById('selectedTone').value = '';
            document.getElementById('additional_context').value = '';
            // Reset tone buttons
            document.querySelectorAll('.tone-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
            });
        }

        // Handle tone selection
        document.querySelectorAll('.tone-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Reset all buttons
                document.querySelectorAll('.tone-btn').forEach(btn => {
                    btn.classList.remove('bg-indigo-600', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-700');
                });
                
                // Highlight selected button
                this.classList.remove('bg-white', 'text-gray-700');
                this.classList.add('bg-indigo-600', 'text-white');
                
                // Store selected tone
                document.getElementById('selectedTone').value = this.dataset.tone;
            });
        });

        function generateWithAI() {
            const templateId = document.getElementById('templateId').value;
            const tone = document.getElementById('selectedTone').value;
            const additionalContext = document.getElementById('additional_context').value;

            if (!tone) {
                alert('Please select a tone for your post');
                return;
            }

            // Show loading state
            const generateButton = event.target;
            const originalText = generateButton.innerHTML;
            generateButton.disabled = true;
            generateButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            `;

            // Make API call
            fetch(`/viral-content/${templateId}/inspire`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tone: tone,
                    additional_context: additionalContext
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `/post-generator?template=${data.template_id}`;
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while generating the post');
            })
            .finally(() => {
                // Reset button state
                generateButton.disabled = false;
                generateButton.innerHTML = originalText;
            });
        }

        function toggleBookmark(templateId) {
            const button = document.querySelector(`.bookmark-btn[data-template-id="${templateId}"]`);
            const icon = button.querySelector('svg');
            
            fetch(`/viral-content/${templateId}/bookmark`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_bookmarked) {
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-indigo-600');
                        icon.setAttribute('fill', 'currentColor');
                    } else {
                        icon.classList.remove('text-indigo-600');
                        icon.classList.add('text-gray-400');
                        icon.setAttribute('fill', 'none');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while bookmarking the template');
            });
        }
    </script>
    @endpush
</x-app-layout> 