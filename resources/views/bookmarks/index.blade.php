@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar-navigation />

    <!-- Main Content Area -->
    <main class="flex-1 ml-56">
        <div class="py-6">
            <div class="max-w-[1600px] mx-auto px-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Bookmarks</h1>
                        <p class="mt-1 text-sm text-gray-500">Your saved posts and content ideas</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="mt-8">
                    <!-- Bookmarks Grid -->
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
                        @forelse($bookmarkedPosts as $bookmark)
                            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200" data-post-id="{{ $bookmark->post_id }}">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-semibold text-gray-900">{{ $bookmark->post->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $bookmark->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <button onclick="removeBookmark({{ $bookmark->post_id }})" class="text-yellow-500 hover:text-yellow-600">
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="prose max-w-none text-gray-600">
                                        {{ $bookmark->post->content }}
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $bookmark->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="copyToClipboard({{ $bookmark->post_id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                </svg>
                                                Copy
                                            </button>
                                            <button onclick="shareOnLinkedIn({{ $bookmark->post_id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                                Share
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="col-span-full">
                                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 text-center py-12">
                                    <div class="mx-auto w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No bookmarks yet</h3>
                                    <p class="mt-1 text-sm text-gray-500">Save interesting posts and content ideas for later.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('post-generator.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Create New Post
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($bookmarkedPosts->hasPages())
                        <div class="mt-6">
                            {{ $bookmarkedPosts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
function removeBookmark(postId) {
    if (!confirm('Are you sure you want to remove this bookmark?')) return;

    fetch(`/post-generator/bookmark/${postId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the bookmark card from the UI
            const bookmarkCard = document.querySelector(`[data-post-id="${postId}"]`);
            if (bookmarkCard) {
                bookmarkCard.remove();
                
                // Show feedback message
                const message = 'Bookmark removed';
                const alertDiv = document.createElement('div');
                alertDiv.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg text-sm';
                alertDiv.textContent = message;
                document.body.appendChild(alertDiv);
                setTimeout(() => alertDiv.remove(), 2000);

                // If no more bookmarks, reload to show empty state
                const remainingBookmarks = document.querySelectorAll('[data-post-id]');
                if (remainingBookmarks.length === 0) {
                    window.location.reload();
                }
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function copyToClipboard(postId) {
    const postContent = document.querySelector(`[data-post-id="${postId}"] .prose`).innerText;
    navigator.clipboard.writeText(postContent)
        .then(() => {
            // Show feedback message
            const message = 'Content copied to clipboard!';
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg text-sm';
            alertDiv.textContent = message;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 2000);
        })
        .catch(err => {
            console.error('Failed to copy content: ', err);
        });
}

function shareOnLinkedIn(postId) {
    const postContent = document.querySelector(`[data-post-id="${postId}"] .prose`).innerText;
    const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(window.location.href)}&text=${encodeURIComponent(postContent)}`;
    window.open(linkedInUrl, '_blank');
}
</script>
@endpush 