<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between py-4">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Bookmarks</h1>
                            <p class="mt-1 text-sm text-gray-500">{{ $bookmarkedPosts->total() }} saved posts</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                @if($bookmarkedPosts->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookmarks</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by saving some posts.</p>
                            <div class="mt-6">
                                <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Generate New Post
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($bookmarkedPosts as $post)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-700 font-medium">{{ substr($post->user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                onclick="toggleBookmark({{ $post->id }})"
                                                class="bookmark-btn inline-flex items-center p-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                data-post-id="{{ $post->id }}">
                                            <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">{{ $post->generated_content }}</p>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between border-t pt-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $post->postType->name }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $post->tone->name }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Copy
                                            </button>
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Share
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $bookmarkedPosts->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleBookmark(postId) {
            fetch(`/bookmarks/${postId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the bookmark');
            });
        }
    </script>
    @endpush
</x-app-layout> 