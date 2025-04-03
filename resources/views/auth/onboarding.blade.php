<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Your Profile - NextViralPost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f7ff;
        }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%);
        }
        .gradient-border {
            border-image: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #0077B5 75%, #E1306C 100%) 1;
        }
        .option-button {
            transition: all 0.2s ease;
        }
        .option-button.selected {
            background-color: #EEF2FF;
            border-color: #0077B5;
            color: #0077B5;
        }
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background-color: #0077B5;
            color: white;
        }
        .step-indicator.completed {
            background-color: #10B981;
            color: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 gradient-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-xl font-bold gradient-text">NextViralPost</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">Step <span id="current-step">1</span> of 3</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center p-4">
            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Left Side - Image -->
                    <div class="hidden md:block md:w-1/3 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-pink-500/20"></div>
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" 
                             class="object-cover w-full h-full" alt="People celebrating success">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                            <div class="max-w-md">
                                <h3 class="text-white text-xl font-bold mb-2">Join our community of creators</h3>
                                <p class="text-gray-200 text-sm">Get personalized content recommendations and start creating viral content today.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="w-full md:w-2/3 p-8">
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold mb-2">
                                <span class="gradient-text">Let's get to know you better!</span>
                            </h1>
                            <p class="text-gray-600">Help us personalize your experience</p>
                        </div>

                        <!-- Progress Steps -->
                        <div class="flex justify-between mb-8">
                            <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium border-2 border-gray-300 active" data-step="1">1</div>
                            <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium border-2 border-gray-300" data-step="2">2</div>
                            <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium border-2 border-gray-300" data-step="3">3</div>
                        </div>

                        <form id="onboardingForm" class="space-y-8">
                            @csrf
                            <!-- Hidden inputs for form data -->
                            <input type="hidden" name="role_id" id="role_id">
                            <input type="hidden" name="interest_ids" id="interest_ids">
                            
                            <!-- Step 1: Role Selection -->
                            <div id="step-1" class="step-content">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">I am a...</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($roles as $role)
                                    <button type="button" class="option-button text-left px-4 py-3 border-2 rounded-xl hover:border-blue-600 hover:bg-blue-50" data-role-id="{{ $role->id }}">
                                        <span class="font-medium">{{ $role->name }}</span>
                                    </button>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button type="button" class="next-step-btn gradient-bg text-white rounded-xl px-6 py-2 font-medium hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors">
                                        Next
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Industry Selection -->
                            <div id="step-2" class="step-content hidden">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Industry</h2>
                                <div class="mb-6">
                                    <select id="industry" name="industry_id" class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-0">
                                        <option value="">Select your industry</option>
                                        @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-6 flex justify-between">
                                    <button type="button" class="prev-step-btn border-2 border-gray-300 text-gray-700 rounded-xl px-6 py-2 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-colors">
                                        Back
                                    </button>
                                    <button type="button" class="next-step-btn gradient-bg text-white rounded-xl px-6 py-2 font-medium hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors">
                                        Next
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Interest Selection -->
                            <div id="step-3" class="step-content hidden">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">I want to go viral on...</h2>
                                <p class="text-gray-500 mb-4">Select at least one interest (you can select multiple)</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($interests as $interest)
                                    <button type="button" class="option-button text-left px-4 py-3 border-2 rounded-xl hover:border-blue-600 hover:bg-blue-50" data-interest-id="{{ $interest->id }}">
                                        <span class="font-medium">{{ $interest->name }}</span>
                                    </button>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex justify-between">
                                    <button type="button" class="prev-step-btn border-2 border-gray-300 text-gray-700 rounded-xl px-6 py-2 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-colors">
                                        Back
                                    </button>
                                    <button type="submit" id="submit-button" class="gradient-bg text-white rounded-xl px-6 py-2 font-medium hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors">
                                        Complete Profile
                                    </button>
                                </div>
                            </div>

                            <div id="error-message" class="hidden text-red-500 text-sm text-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Handle button selections
        document.querySelectorAll('.option-button').forEach(button => {
            button.addEventListener('click', function() {
                const isInterest = this.dataset.interestId !== undefined;
                if (!isInterest) {
                    // Single select for roles
                    document.querySelectorAll('[data-role-id]').forEach(btn => {
                        btn.classList.remove('selected');
                    });
                }
                this.classList.toggle('selected');
            });
        });

        // Step navigation
        const steps = document.querySelectorAll('.step-content');
        const stepIndicators = document.querySelectorAll('.step-indicator');
        const currentStepElement = document.getElementById('current-step');
        let currentStep = 1;

        function updateStepVisibility() {
            steps.forEach((step, index) => {
                if (index + 1 === currentStep) {
                    step.classList.remove('hidden');
                } else {
                    step.classList.add('hidden');
                }
            });

            stepIndicators.forEach((indicator, index) => {
                if (index + 1 < currentStep) {
                    indicator.classList.remove('active');
                    indicator.classList.add('completed');
                } else if (index + 1 === currentStep) {
                    indicator.classList.add('active');
                    indicator.classList.remove('completed');
                } else {
                    indicator.classList.remove('active', 'completed');
                }
            });

            currentStepElement.textContent = currentStep;
        }

        document.querySelectorAll('.next-step-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep < 3) {
                    currentStep++;
                    updateStepVisibility();
                }
            });
        });

        document.querySelectorAll('.prev-step-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepVisibility();
                }
            });
        });

        // Handle form submission
        document.getElementById('onboardingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('submit-button');
            const errorMessage = document.getElementById('error-message');
            
            // Get selected values
            const selectedRole = document.querySelector('.option-button[data-role-id].selected')?.dataset.roleId;
            const selectedIndustry = document.getElementById('industry').value;
            const selectedInterests = Array.from(document.querySelectorAll('.option-button[data-interest-id].selected'))
                .map(button => button.dataset.interestId);

            // Validate selections
            if (!selectedRole || !selectedIndustry) {
                errorMessage.textContent = 'Please select your role and industry before proceeding.';
                errorMessage.classList.remove('hidden');
                return;
            }

            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;

            // Create FormData object
            const formData = new FormData();
            formData.append('role_id', selectedRole);
            formData.append('industry_id', selectedIndustry);
            
            // Only append interest_ids if there are selected interests
            if (selectedInterests.length > 0) {
                selectedInterests.forEach(interestId => {
                    formData.append('interest_ids[]', interestId);
                });
            }
            
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Submit data
            fetch('/onboarding', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    }
                    return response.json().then(data => {
                        throw new Error(data.message || 'An error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.errors) {
                    errorMessage.textContent = Object.values(data.errors).flat().join(', ');
                    errorMessage.classList.remove('hidden');
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = error.message || 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Complete Profile';
            });
        });
    </script>
</body>
</html> 