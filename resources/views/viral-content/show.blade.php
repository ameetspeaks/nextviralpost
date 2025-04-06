@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Repurpose and Generated Content Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Repurpose This Template -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Repurpose This Template</h3>
                    
                    <form id="repurposeForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="tone_id" class="block text-sm font-medium text-gray-700">Select Tone</label>
                            <select name="tone_id" id="tone_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Choose a tone...</option>
                                @foreach($tones as $tone)
                                    <option value="{{ $tone->id }}">{{ $tone->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="raw_thoughts" class="block text-sm font-medium text-gray-700">Your Thoughts</label>
                            <textarea name="raw_thoughts" id="raw_thoughts" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Add your personal thoughts or context here..."></textarea>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                Copy
                            </button>
                            <button type="button" onclick="shareOnLinkedIn()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                Share on LinkedIn
                            </button>
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed" disabled>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                User Template (Coming Soon)
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Generated Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Generated Content</h3>
                    <div id="generatedContent" class="prose max-w-none min-h-[200px]">
                        <div class="text-center text-gray-500 py-8">
                            <p>Your repurposed content will appear here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $template->username }}</h2>
                        <p class="text-sm text-gray-500">Posted on {{ $template->date_posted->format('M d, Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-heart text-red-500"></i> {{ $template->likes }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-comment text-blue-500"></i> {{ $template->comments }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-share text-green-500"></i> {{ $template->shares }}
                        </span>
                    </div>
                </div>
                
                <div class="prose max-w-none">
                    {!! nl2br(e($template->post_content)) !!}
                </div>

                @if($template->post_link)
                <div class="mt-4">
                    <a href="{{ $template->post_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                        View Original Post →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('repurposeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const generatedContent = document.getElementById('generatedContent');
    
    // Show loading state
    generatedContent.innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
            <p class="mt-2 text-gray-500">Generating content...</p>
        </div>
    `;
    
    fetch(`/viral-content/{{ $template->id }}/repurpose`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            generatedContent.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <p>${data.error}</p>
                </div>
            `;
        } else {
            generatedContent.innerHTML = `
                <div class="prose max-w-none">
                    ${data.repurposed_content.replace(/\n/g, '<br>')}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        generatedContent.innerHTML = `
            <div class="text-center text-red-500 py-8">
                <p>An error occurred. Please try again.</p>
            </div>
        `;
    });
});

function copyToClipboard() {
    const generatedContent = document.getElementById('generatedContent');
    const content = generatedContent.innerText;
    navigator.clipboard.writeText(content).then(() => {
        alert('Content copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy content: ', err);
    });
}

function shareOnLinkedIn() {
    const generatedContent = document.getElementById('generatedContent');
    const content = generatedContent.innerText;
    const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(window.location.href)}&text=${encodeURIComponent(content)}`;
    window.open(linkedInUrl, '_blank');
}
</script>
@endpush
@endsection 