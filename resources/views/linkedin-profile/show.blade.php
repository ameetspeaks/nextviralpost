@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">LinkedIn Profile Analysis</h1>
        
        <!-- Overall Score -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Overall Profile Score</h2>
            <div class="flex items-center">
                <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-3xl font-bold text-blue-600">{{ $profile->overall_score }}</span>
                </div>
                <div class="ml-6">
                    <p class="text-gray-600">Your profile is 
                        @if($profile->overall_score >= 70)
                            well optimized
                        @elseif($profile->overall_score >= 50)
                            moderately optimized
                        @else
                            needs improvement
                        @endif
                    .</p>
                </div>
            </div>
        </div>

        <!-- Section Scores -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Section Scores</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($profile->section_scores as $section => $score)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-medium mb-2">{{ ucfirst($section) }}</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $score }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $score }}%</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Improvement Suggestions -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Improvement Suggestions</h2>
            @foreach($profile->improvement_suggestions as $section => $suggestions)
            <div class="mb-6">
                <h3 class="font-medium mb-2">{{ ucfirst($section) }}</h3>
                <ul class="list-disc pl-5 space-y-2">
                    @foreach($suggestions as $suggestion)
                    <li class="text-gray-700">{{ $suggestion }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex space-x-4">
            <a href="{{ route('linkedin-profile.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to Profiles
            </a>
            <a href="{{ route('linkedin-profile.edit', $profile->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection 