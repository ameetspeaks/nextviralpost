@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 flex-shrink-0">
            @include('components.sidebar-navigation')
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-2xl font-bold mb-6 text-blue-600">LinkedIn Profile Optimization</h1>
                    
                    <!-- Upload Section -->
                    <div id="uploadSection" class="mb-8">
                        <form id="uploadForm" class="space-y-4" enctype="multipart/form-data">
                            @csrf
                            <div class="border-2 border-dashed border-blue-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors duration-300 bg-blue-50">
                                <input type="file" id="pdfFile" name="pdf_file" accept=".pdf" class="hidden">
                                <label for="pdfFile" class="cursor-pointer block">
                                    <div class="mx-auto w-20 h-20 mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="h-10 w-10 text-blue-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium text-gray-700 mb-2">Click to upload your LinkedIn profile PDF</p>
                                    <p class="text-sm text-gray-500">Drag and drop your file here or click to browse</p>
                                    <p class="mt-2 text-xs text-blue-600 font-semibold">MAX. FILE SIZE: 10MB</p>
                                </label>
                            </div>

                            <!-- Upload Progress -->
                            <div id="uploadProgress" class="hidden">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Uploading file...</span>
                                    </div>
                                    <span class="text-sm font-medium text-blue-600" id="uploadPercentage">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="uploadProgressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                </div>
                            </div>

                            <button type="submit" id="analyzeButton" class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-medium text-lg cursor-not-allowed transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-50" disabled>
                                Analyze Profile
                            </button>
                        </form>
                    </div>

                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="hidden">
                        <div class="flex flex-col items-center justify-center p-8">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
                            <p class="mt-4 text-lg text-gray-600">Analyzing your profile...</p>
                            <p class="text-sm text-gray-500">This may take a few moments</p>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div id="resultsSection" class="hidden space-y-8">
                        <!-- New Analysis Button -->
                        <div class="flex justify-end mb-4">
                            <button id="newAnalysisButton" class="bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                New Analysis
                            </button>
                        </div>

                        <!-- Overall Score -->
                        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Overall Profile Score</h2>
                            <div class="flex items-center justify-center">
                                <div class="relative w-40 h-40">
                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3"/>
                                        <path id="scoreCircle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#3B82F6" stroke-width="3" stroke-dasharray="0, 100" class="transition-all duration-1000 ease-out"/>
                                        <text x="18" y="20.35" class="text-3xl font-bold" text-anchor="middle" fill="#1F2937">0</text>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Section Scores and Suggestions -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Section Scores -->
                            <div class="space-y-6">
                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Section Scores</h2>
                                    <div class="space-y-6" id="sectionScores">
                                        <!-- Section scores will be dynamically added here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Improvement Suggestions -->
                            <div class="space-y-6">
                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Priority Improvements</h2>
                                    <div class="space-y-6" id="improvementSuggestions">
                                        <!-- Improvement suggestions will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Section Analysis -->
                        <div id="sectionDetails" class="space-y-6">
                            <!-- Section details will be dynamically added here -->
                        </div>

                        <!-- Competitor Analysis -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Competitor Analysis</h2>
                            <div class="space-y-6" id="competitorAnalysis">
                                <!-- Competitor analysis will be dynamically added here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('pdfFile');
    const analyzeButton = document.getElementById('analyzeButton');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadProgressBar = document.getElementById('uploadProgressBar');
    const uploadPercentage = document.getElementById('uploadPercentage');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultsSection = document.getElementById('resultsSection');
    const errorDiv = document.getElementById('error-message');

    // Handle drag and drop
    const dropZone = document.querySelector('.border-dashed');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-100');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-100');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        fileInput.files = dt.files;
        handleFileSelect(file);
    }

    // Handle file selection
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        handleFileSelect(file);
    });

    function handleFileSelect(file) {
        if (file) {
            if (file.size > 10 * 1024 * 1024) { // 10MB
                showError('File size must be less than 10MB');
                fileInput.value = '';
                updateButtonState(false);
            } else if (file.type !== 'application/pdf') {
                showError('Please upload a PDF file');
                fileInput.value = '';
                updateButtonState(false);
            } else {
                startUploadSimulation();
            }
        }
    }

    function updateButtonState(enabled) {
        analyzeButton.disabled = !enabled;
        if (enabled) {
            analyzeButton.classList.remove('bg-gray-400');
            analyzeButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
        } else {
            analyzeButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            analyzeButton.classList.add('bg-gray-400');
        }
    }

    function startUploadSimulation() {
        uploadProgress.classList.remove('hidden');
        updateButtonState(false);
        
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += 2;
            if (progress > 100) progress = 100;
            
            uploadProgressBar.style.width = progress + '%';
            uploadPercentage.textContent = progress + '%';
            
            if (progress === 100) {
                clearInterval(progressInterval);
                setTimeout(() => {
                    updateButtonState(true);
                }, 500);
            }
        }, 50);
    }

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate file selection
        if (!fileInput.files || !fileInput.files[0]) {
            showError('Please select a PDF file');
            return;
        }

        // Validate file type
        const file = fileInput.files[0];
        if (file.type !== 'application/pdf') {
            showError('Please upload a PDF file');
            return;
        }

        // Validate file size (10MB max)
        if (file.size > 10 * 1024 * 1024) {
            showError('File size must be less than 10MB');
            return;
        }

        try {
            // Show loading state
            analyzeButton.disabled = true;
            analyzeButton.innerHTML = 'Analyzing...';
            hideError();
            resultsSection.innerHTML = '<div class="text-center"><div class="spinner"></div><p>Analyzing your profile...</p></div>';

            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Server response:', data); // Debug log

            if (!data.success) {
                throw new Error(data.message || 'Unknown error occurred');
            }

            displayResults(data.data);

        } catch (error) {
            console.error('Error:', error);
            showError(error.message || 'An error occurred while analyzing the profile');
        } finally {
            analyzeButton.disabled = false;
            analyzeButton.innerHTML = 'Analyze Profile';
        }
    });

    // Add new analysis button functionality
    document.getElementById('newAnalysisButton')?.addEventListener('click', function() {
        document.getElementById('uploadSection').classList.remove('hidden');
        document.getElementById('resultsSection').classList.add('hidden');
        form.reset();
        updateButtonState(false);
    });

    function displayResults(profile) {
        if (!profile || typeof profile !== 'object') {
            throw new Error('Invalid response data');
        }

        console.log('Displaying results for:', profile); // Debug log

        let html = '<div class="space-y-6">';
        
        // Overall Score
        if (typeof profile.overall_score === 'number') {
            html += `
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Overall Profile Score</h2>
                    <div class="flex items-center justify-center">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3"/>
                                <path id="scoreCircle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#3B82F6" stroke-width="3" stroke-dasharray="0, 100" class="transition-all duration-1000 ease-out"/>
                                <text x="18" y="20.35" class="text-3xl font-bold" text-anchor="middle" fill="#1F2937">${profile.overall_score}</text>
                            </svg>
                        </div>
                    </div>
                </div>
            `;
        }

        // Section Scores
        if (profile.section_scores && typeof profile.section_scores === 'object') {
            html += `
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Section Scores</h2>
                    <div class="space-y-6" id="sectionScores">
            `;

            Object.entries(profile.section_scores).forEach(([section, score]) => {
                if (score !== null && score !== undefined) {
                    html += `
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-700 font-medium">${section.charAt(0).toUpperCase() + section.slice(1)}</span>
                                <span class="text-gray-400 text-sm ml-2">${Math.round(score * 100)}%</span>
                            </div>
                            <span class="text-blue-600 font-bold">${Math.round(score * 100)}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000 ease-out" style="width: ${score * 100}%"></div>
                        </div>
                    `;
                }
            });

            html += '</div></div>';
        }

        // Improvement Suggestions
        if (profile.improvement_suggestions && typeof profile.improvement_suggestions === 'object') {
            html += `
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Priority Improvements</h2>
                    <div class="space-y-6" id="improvementSuggestions">
            `;

            profile.improvement_suggestions.forEach((section, index) => {
                html += `
                    <div class="flex items-start space-x-3 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                            section.priority === 'HIGH' ? 'bg-red-100 text-red-800' :
                            section.priority === 'MEDIUM' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-green-100 text-green-800'
                        }">
                            ${section.priority}
                        </span>
                        <div class="flex-1">
                            <p class="text-gray-700">${section.message}</p>
                            <p class="text-gray-500 text-xs mt-1">${section.impact}</p>
                        </div>
                    </div>
                `;
            });

            html += '</div></div>';
        }

        // Detailed Section Analysis
        if (profile.section_details && typeof profile.section_details === 'object') {
            html += '<div id="sectionDetails" class="space-y-6">';
            Object.entries(profile.section_details).forEach(([section, details]) => {
                html += `
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">${section.charAt(0).toUpperCase() + section.slice(1)}</h2>
                        <p class="text-gray-700">${details}</p>
                    </div>
                `;
            });
            html += '</div>';
        }

        // Competitor Analysis
        if (profile.competitor_analysis && typeof profile.competitor_analysis === 'object') {
            html += `
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Competitor Analysis</h2>
                    <div class="space-y-6" id="competitorAnalysis">
            `;
            Object.entries(profile.competitor_analysis).forEach(([industry, analysis]) => {
                html += `
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium mb-2">${industry.charAt(0).toUpperCase() + industry.slice(1)}</h3>
                        <p class="text-gray-700">${analysis}</p>
                    </div>
                `;
            });
            html += '</div></div>';
        }

        html += '</div>';
        resultsSection.innerHTML = html;
        resultsSection.classList.remove('hidden');
        resultsSection.scrollIntoView({ behavior: 'smooth' });
    }

    function showError(message) {
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    function hideError() {
        errorDiv.textContent = '';
        errorDiv.classList.add('hidden');
    }
});

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

<style>
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-left-color: #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endsection 