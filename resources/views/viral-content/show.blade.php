<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Template Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 text-lg font-medium">{{ substr($template->username, 0, 1) }}</span>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold text-gray-900">{{ $template->username }}</h1>
                                <p class="text-sm text-gray-500">{{ $template->date_posted->format('F j, Y') }}</p>
                            </div>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-full bookmark-button" data-template-id="{{ $template->id }}">
                            <svg class="w-6 h-6 {{ $template->isBookmarkedBy(Auth::user()) ? 'text-yellow-500 fill-current' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Template Content -->
                    <div class="prose max-w-none mb-6">
                        <p class="text-gray-800 whitespace-pre-line">{{ $template->post_content }}</p>
                    </div>

                    <!-- Engagement Stats -->
                    <div class="flex items-center justify-between py-4 border-t border-gray-100">
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>{{ $template->likes }}</span>
                            </div>
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>{{ $template->comments }}</span>
                            </div>
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                                <span>{{ $template->shares }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">{{ $template->bookmark_count }} bookmarks</span>
                            <span class="text-sm text-gray-500">{{ $template->inspiration_count }} inspired</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center py-4 border-t border-gray-100">
                        <a href="{{ $template->post_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                            View Original Post
                        </a>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 inspire-button" data-template-id="{{ $template->id }}">
                            Use as Template
                        </button>
                    </div>

                    <!-- Inspired By Section -->
                    @if($template->inspiration_count > 0)
                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Inspired By</h2>
                            <div class="space-y-4">
                                @foreach($template->inspiredBy as $interaction)
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-600 text-sm">{{ substr($interaction->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $interaction->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $interaction->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bookmark functionality
            const bookmarkButton = document.querySelector('.bookmark-button');
            if (bookmarkButton) {
                bookmarkButton.addEventListener('click', async function() {
                    const templateId = this.dataset.templateId;
                    try {
                        const response = await fetch(`/viral-content/${templateId}/bookmark`, {
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
                                svg.classList.add('text-yellow-500', 'fill-current');
                                svg.classList.remove('text-gray-400');
                            } else {
                                svg.classList.remove('text-yellow-500', 'fill-current');
                                svg.classList.add('text-gray-400');
                            }
                        }
                    } catch (error) {
                        console.error('Failed to update bookmark status:', error);
                    }
                });
            }

            // Inspire functionality
            const inspireButton = document.querySelector('.inspire-button');
            if (inspireButton) {
                inspireButton.addEventListener('click', async function() {
                    const templateId = this.dataset.templateId;
                    try {
                        const response = await fetch(`/viral-content/${templateId}/inspire`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        });

                        const data = await response.json();
                        if (data.success) {
                            // Redirect to post generator with template data
                            window.location.href = `/post-generator?template=${templateId}`;
                        }
                    } catch (error) {
                        console.error('Failed to record inspiration:', error);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 