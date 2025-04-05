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

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Repurposed Content
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
</script>
@endpush
@endsection 