@php
use Illuminate\Support\Facades\Auth;
@endphp

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
                            <h1 class="text-2xl font-semibold text-gray-900">My Posts</h1>
                            <p class="mt-1 text-sm text-gray-500">Manage and track your generated posts</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('post-generator.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Generate New Post
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                <!-- Keywords Filter -->
                @if(count($keywords) > 0)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter by Keywords</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($keywords as $keyword)
                                    <button class="keyword-filter px-3 py-1 rounded-full text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 transition-colors">
                                        {{ $keyword }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Posts Grid -->
                @if($posts->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first post.</p>
                            <div class="mt-6">
                                <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Generate Your First Post
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($posts as $post)
                            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                                <div class="p-6">
                                    <!-- Post Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=6366f1&color=fff" 
                                                 alt="{{ $fullName }}" 
                                                 class="w-12 h-12 rounded-full">
                                            <div class="ml-3">
                                                <h3 class="text-base font-semibold text-gray-900">{{ $fullName }}</h3>
                                                <p class="text-sm text-gray-500">Posted {{ $post->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <div class="prose max-w-none mb-4">
                                        <p class="text-gray-800 whitespace-pre-wrap">{{ $post->generated_content }}</p>
                                    </div>

                                    <!-- Keywords -->
                                    @if($post->keywords)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(explode(',', $post->keywords) as $keyword)
                                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                                    {{ trim($keyword) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Post Footer -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                        <div class="flex space-x-4">
                                            <button onclick="copyToClipboard('{{ $post->id }}')" class="flex items-center text-gray-600 hover:text-indigo-600">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                                </svg>
                                                Copy
                                            </button>
                                            <a href="{{ route('my-posts.share', $post->id) }}" target="_blank" class="flex items-center text-gray-600 hover:text-indigo-600">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                </svg>
                                                Share on LinkedIn
                                            </a>
                                        </div>
                                        <a href="{{ route('my-posts.show', $post->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    @push('scripts')
    <script>
        // Copy to clipboard functionality
        function copyToClipboard(postId) {
            fetch(`/my-posts/${postId}/copy`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    navigator.clipboard.writeText(data.content)
                        .then(() => {
                            // Show success message
                            const button = document.querySelector(`button[onclick="copyToClipboard('${postId}')"]`);
                            const originalText = button.innerHTML;
                            button.innerHTML = `
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Copied!
                            `;
                            button.classList.remove('text-gray-600', 'hover:text-indigo-600');
                            button.classList.add('text-green-600');

                            setTimeout(() => {
                                button.innerHTML = originalText;
                                button.classList.remove('text-green-600');
                                button.classList.add('text-gray-600', 'hover:text-indigo-600');
                            }, 2000);
                        })
                        .catch(err => {
                            console.error('Failed to copy text: ', err);
                            alert('Failed to copy to clipboard. Please try again.');
                        });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        // Keyword filtering functionality
        document.querySelectorAll('.keyword-filter').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('bg-indigo-100');
                this.classList.toggle('text-indigo-700');
                // Add your filtering logic here
            });
        });
    </script>
    @endpush
</x-app-layout> 