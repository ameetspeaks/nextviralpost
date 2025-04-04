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
                            <h1 class="text-2xl font-semibold text-gray-900">Post Details</h1>
                            <p class="mt-1 text-sm text-gray-500">View and manage your post</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('my-posts.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Posts
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-start justify-between mb-6">
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
                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $post->generated_content }}</p>
                        </div>

                        <!-- Keywords -->
                        @if($post->keywords)
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Keywords</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $post->keywords) as $keyword)
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between">
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
                                <form action="{{ route('my-posts.destroy', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script>
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
    </script>
    @endpush
</x-app-layout> 